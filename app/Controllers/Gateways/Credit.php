<?php

namespace WPP\Controllers\Gateways;

use WPP\Controllers\Checkout\Credit as Checkout;
use WPP\Controllers\Thankyou\Credit as ThankyouCredit;
use WPP\Helpers\Config;
use WPP\Services\WooCommerce\Gateways\InterfaceGateways;
use WPP\Controllers\Webhooks\Credit as Webhooks;
use WPP\Model\Entity\Settings;
use WPP\Services\WooCommerce\Gateways\Gateway;

/**
 * Structure the billet payment method
 * @package Controllers
 * @since 1.0.0
 */
class Credit extends Gateway implements InterfaceGateways
{
    private array $card_fields;

    public function __construct() {
        
        $this->id                 = "wc-pagarme-credit";
        $this->icon               = Config::__images( "icons/credit.svg");
        $this->has_fields         = false;
        $this->method_title       = __( "Pagar.me - Credit Card", "wc-pagarme-payments" );
        $this->method_description = __( "Pagar.me - Pay with credit card", "wc-pagarme-payments" );

        $this->supports = [
            "products"
        ];

        $this->init_form_fields();
        $this->init_settings();

        $this->title       = $this->get_option( "title" );
        $this->description = $this->get_option( "description" );
        $this->enabled     = $this->get_option( "enabled" );

        $this->card_fields = [];

        add_action( 'woocommerce_thankyou_' . $this->id, [ $this, 'show_thankyou_page' ]);

        if ( is_admin() ) {
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, [ $this, 'process_admin_options' ] );
        }

        new Webhooks( $this->id, get_class( $this ) );

        parent::__construct();
    }


    public function init_form_fields(): void
    {
        wp_enqueue_style( 'wpp-credit-page', Config::__dist( "styles/admin/pages/credit/index.css") );
        wp_enqueue_script( 'wpp-credit-page', Config::__dist( "scripts/admin/pages/credit/index.js") );

        $this->form_fields = [
            "enabled" => [
                "title"       => __( "Enable", "wc-pagarme-payments" ),
                "label"       => __( "Enable Gateway", "wc-pagarme-payments" ),
                "type"        => "checkbox",
                "description" => __( "Check this option to activate the payment method", "wc-pagarme-payments" ),
                "default"     => "no",
                "desc_tip"    => true
            ],

            "title" => [
                "title"       => __( "Title", "wc-pagarme-payments" ),
                "type"        => "text",
                "description" => __( "This controls the title which the user sees during checkout.", "wc-pagarme-payments" ),
                "default"     => __( "Pagar.me Credit Card", "wc-pagarme-payments" ),
                "desc_tip"    => true
            ],

            "description" => [
                "title"       => __( "Description", "wc-pagarme-payments" ),
                "type"        => "textarea",
                "description" => __( "This controls the description which the user sees during checkout.", "wc-pagarme-payments" ),
                "default"     => __( "Pay with credit card using Pagar.me.", "wc-pagarme-payments" ),
                "desc_tip"    => true
            ],

            "installments_quant" => [
                "title"       => __( "Instalments Quantity", "wc-pagarme-payments" ),
                "type"        => "number",
                "description" => __( "This controls the quantity of installments for credit card payments.", "wc-pagarme-payments" ),
                "default"     => __( "Max of installments.", "wc-pagarme-payments" ),
                "desc_tip"    => true
            ],

            "installments_config" => [
                "title"       => __( "Instalments Configuration", "wc-pagarme-payments" ),
                "type"        => "button",
                "default"     => __( "Configure", "wc-pagarme-payments" ),
                "description" => __( "This controls the quantity of installments and the fees for credit card payments.", "wc-pagarme-payments" ),
                "desc_tip"    => true
            ],

            "logs" => [
                "title"       => __( "WooCommerce Logs", "wc-pagarme-payments" ),
                "label"       => __( "Enable credit card logs.", "wc-pagarme-payments" ),
                "type"        => "checkbox",
                "description" => __( "Check this option to activate the log for this method.", "wc-pagarme-payments" ),
                "default"     => "yes",
                "desc_tip"    => true
            ],
        ];
        
    }


    public function payment_fields(): void
    {

        if ( $this->description ) {

            $model = new Settings();

            if ( $model->get_payment_mode() !== 'production' ) {
                $this->description .= __( " Test mode activate! In this mode transactions are not real.", "wc-pagarme-payments" );
                $this->description  = trim( $this->description );
            }
            
            echo wpautop( wp_kses_post( $this->description ) );
        }

        new Checkout;
    }


    public function validate_fields(): bool
    {
        $fields['token']         = [];
        $fields['owner']         = isset( $_POST['wpp-card-owner'] ) && $_POST['wpp-card-owner'] ? filter_var( $_POST['wpp-card-owner'], FILTER_SANITIZE_SPECIAL_CHARS ) : false;
        $fields['expiry']        = isset( $_POST['wpp-card-expiry'] ) && $_POST['wpp-card-expiry'] ? filter_var( $_POST['wpp-card-expiry'], FILTER_SANITIZE_SPECIAL_CHARS ) : false;
        $fields['brand']         = isset( $_POST['wpp-card-brand'] ) && $_POST['wpp-card-brand'] ? filter_var( $_POST['wpp-card-brand'], FILTER_SANITIZE_SPECIAL_CHARS ) : false;
        $fields['installments']  = isset( $_POST['wpp-card-installments'] ) && $_POST['wpp-card-installments'] ? filter_var( $_POST['wpp-card-installments'], FILTER_SANITIZE_NUMBER_INT ) : false;
        $token                   = isset( $_POST['wpp-card-token'] ) && $_POST['wpp-card-token'] ? filter_var( $_POST['wpp-card-token'] ) : false;

        $token = json_decode( stripslashes( $token ) );

        if ( $token && is_object( $token )) {
            $fields['token'] = ( array ) $token;
            if ( isset( $token->card ) ) {
                $fields['token']['card'] = ( array ) $token->card;
            }
        }
        
        foreach ( $fields as $key => $value ) {
            if ( ! $value ) {
                return $this->abort_process( $this->get_invalid_field_message( $key ) );
            }
        }

        $this->card_fields = $fields;
        return true;
    }

    private function get_invalid_field_message( string $field ): string
    {
        switch ( $field ) {
            case 'owner':
                $message = __( 'Pagar.me: The "Card Owner" field must be filled in correctly!', 'wc-pagarme-payments' );
                break;
            
            case 'number':
                $message = __( 'Pagar.me: The "Card Number" field must be filled in correctly!', 'wc-pagarme-payments' );
                break;
            
            case 'expiry':
                $message = __( 'Pagar.me: The "Expiry Date" field must be filled in correctly!', 'wc-pagarme-payments' );
                break;
            
            case 'installments':
                $message = __( 'Pagar.me: The "Installments" field must be filled in correctly!', 'wc-pagarme-payments' );
                break;

            case 'brand':
                $message = __( 'Pagar.me: Invalid card flag! Check the inserted card number!', 'wc-pagarme-payments' );
                break;
                
            default:
                $message = __( 'Pagar.me: Sorry! Unable to access card token', 'wc-pagarme-payments' );
                break;
        }

        return $message;
    }


    protected function get_payment_method( object $wc_order ): array
    {
        return [
            [
                "amount"      => preg_replace( '/[^0-9]/', '', $wc_order->get_total() ),
                "credit_card" => [
                    "installments"         => $this->card_fields['installments'],
                    "statement_descriptor" => strtoupper( str_replace( ' ', '', get_bloginfo( 'name' ) ) ),
                    "card_token"           => isset( $this->card_fields['token']['id'] ) ? $this->card_fields['token']['id'] : '',
                ],
                "payment_method" => "credit_card"
            ]
        ];
    }


    public function show_thankyou_page( int $wc_order_id ): void
    {
        new ThankyouCredit( $wc_order_id );
    }
    

    protected function validade_transaction( array $charges, object $wc_order ): bool
    {
        global $woocommerce;

        $needed =  [ 'first_six_digits', 'last_four_digits', 'brand', 'holder_name', 'exp_month', 'exp_year' ];
        $metas  = [];

        foreach ( $charges as $charge ) {
            if ( isset( $charge->last_transaction->card ) ) {
                $transaction = (array) $charge->last_transaction;
                $card = (array) $transaction['card'];
                
                if ( array_intersect( $needed, array_keys( $card ) ) === $needed ) {
                    $metas['card_first_digits'] = $card['first_six_digits'];
                    $metas['card_last_digits']  = $card['last_four_digits'];
                    $metas['card_brand']        = $card['brand'];
                    $metas['card_holder_name']  = $card['holder_name'];
                    $metas['card_exp_month']    = $card['exp_month'];
                    $metas['card_exp_year']     = $card['exp_year'];
                    $metas['status']            = $transaction['status'];
                }

            }
        }
        
        $disallowed_status = [ 'wc-failed', 'wc-cancelled' ];
        $status = $this->get_woocommerce_status( $metas['status'] );

        if ( ! empty( $metas ) && ! array_intersect( $disallowed_status, [ $status ] ) ) {
            foreach ( $metas as $key => $meta ) {
                update_post_meta( $wc_order->get_id(), "wc-pagarme-$key", $meta );
            }

            $wc_order->update_status( $status, sprintf( "<strong>%s</strong> :", __( "Pagar.me: ", 'wc-pagarme-payments' ) ), true );

            wc_reduce_stock_levels( $wc_order->get_id() );

            if ( $status === 'wc-on-hold' ) {
                    $wc_order->add_order_note( sprintf( "<strong>%s</strong> : %s.",
                    __( "Pagar.me: ", 'wc-pagarme-payments' ), 
                    __( "Awaiting credit card payment", 'wc-pagarme-payments' )
                ), true );
            }


            $woocommerce->cart->empty_cart();

            return true;
        }

        return false;
    }

}