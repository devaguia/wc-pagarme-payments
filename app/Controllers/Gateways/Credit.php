<?php

namespace WPP\Controllers\Gateways;

use WPP\Controllers\Checkout\Credit as Checkout;
use WPP\Helpers\Config;
use WPP\Services\WooCommerce\Gateways\InterfaceGateways;
use WPP\Controllers\Webhooks\Credit as Webhooks;
use WPP\Services\WooCommerce\Gateways\Gateway;

/**
 * Name: Billet
 * Structure the billet payment method
 * @package Controllers
 * @since 1.0.0
 */
class Credit extends Gateway implements InterfaceGateways
{
    /**
     * @var array
     */
    private $card_fields;

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
        $this->test_mode   = "yes" === $this->get_option( "test_mode" );

        $this->card_fields = [];

        add_action( 'woocommerce_thankyou_' . $this->id, [ $this, 'show_thankyou_page' ]);

        if ( is_admin() ) {
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, [ $this, 'process_admin_options' ] );
        }

        new Webhooks( $this->id, get_class( $this ) );
    }

    /**
     * Create/Edit billet gateway options
     * @since 1.0.0
     * @return void
     */
    public function init_form_fields()
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

            "test_mode" => [
                "title"       => __( "Test Mode", "wc-pagarme-payments" ),
                "label"       => __( "Enable test mode for credit card.", "wc-pagarme-payments" ),
                "type"        => "checkbox",
                "description" => __( "Check this option to activate the test mode.", "wc-pagarme-payments" ),
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

    /**
     * Render the payment fields
     * @since 1.0.0
     * @return void
     */
    public function payment_fields()
    {

        if ( $this->description ) {

            if ( $this->test_mode ) {
                $this->description .= __( " Test mode activate! In this mode transactions are not real.", "wc-pagarme-payments" );
                $this->description  = trim( $this->description );
            }
            
            echo wpautop( wp_kses_post( $this->description ) );
        }

        new Checkout;
    }

    /**
     * Validate the payment fields
     * @since 1.0.0
     * @return boolean
     */
    public function validate_fields()
    {
        $fields['owner']         = isset( $_POST['wpp-card-owner'] ) && $_POST['wpp-card-owner'] ? filter_var( $_POST['wpp-card-owner'], FILTER_SANITIZE_SPECIAL_CHARS ) : false;
        $fields['expiry']        = isset( $_POST['wpp-card-expiry'] ) && $_POST['wpp-card-expiry'] ? filter_var( $_POST['wpp-card-expiry'], FILTER_SANITIZE_SPECIAL_CHARS ) : false;
        $fields['number']        = isset( $_POST['wpp-card-number'] ) && $_POST['wpp-card-number'] ? filter_var( $_POST['wpp-card-number'], FILTER_SANITIZE_SPECIAL_CHARS ) : false;
        $fields['brand']         = isset( $_POST['wpp-card-brand'] ) && $_POST['wpp-card-brand'] ? filter_var( $_POST['wpp-card-brand'], FILTER_SANITIZE_SPECIAL_CHARS ) : false;
        $fields['installments']  = isset( $_POST['wpp-card-installments'] ) && $_POST['wpp-card-installments'] ? filter_var( $_POST['wpp-card-installments'], FILTER_SANITIZE_NUMBER_INT ) : false;
        $fields['token']         = isset( $_POST['wpp-card-token'] ) && $_POST['wpp-card-token'] ? filter_var( $_POST['wpp-card-token'], FILTER_SANITIZE_SPECIAL_CHARS ) : false;

        foreach ( $fields as $key => $value ) {
            if ( ! $value ) {
                return $this->abort_process( $this->get_invalid_field_message( $key ) );
            }
        }
        
        $this->card_fields = $fields;
        return true;
    }

    private function get_invalid_field_message( $field )
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

    /**
     * Method override WPP\Services\WooCommerce\Gateways\Gateway::get_payment_method 
     * @since 1.0.0
     * @param object $wc_order
     * @return array
     */
    protected function get_payment_method( $wc_order )
    {
        return [
            [
                "amount"      => preg_replace( '/[^0-9]/', '', $wc_order->get_total() ),
                "credit_card" => [
                    "installments"         => $this->card_fields['installments'],
                    "statement_descriptor" => "",
                    "card_token"           => $this->card_fields['token'],
                ],
                "payment_method" => "credit_card"
            ]
        ];
    }

    /**
     * Method override WPP\Services\WooCommerce\Gateways\Gateway::show_thankyou_page 
     * @since 1.0.0
     * @return void
     */
    protected function show_thankyou_page()
    {
    }

    /**
     * Method override WPP\Services\WooCommerce\Gateways\Gateway::validade_response 
     * @since 1.0.0
     * @param object $response
     * @return bool
     */
    protected function validade_transaction( $response, $wc_order )
    {
        return false;
    }

}