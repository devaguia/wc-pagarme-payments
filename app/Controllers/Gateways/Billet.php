<?php

namespace WPP\Controllers\Gateways;

use DateInterval;
use DateTime;
use WPP\Controllers\Checkout\Billet as Checkout;
use WPP\Helpers\Config;
use WPP\Services\WooCommerce\Gateways\InterfaceGateways;
use WPP\Controllers\Webhooks\Billet as Webhooks;
use WPP\Services\WooCommerce\Gateways\Gateway;

/**
 * Name: Billet
 * Structure the billet payment method
 * @package Controllers
 * @since 1.0.0
 */
class Billet extends Gateway implements InterfaceGateways
{

    public function __construct() {
        
        $this->id                 = "wc-pagarme-billet";
        $this->icon               = Config::__images( "icons/billet.svg");
        $this->has_fields         = false;
        $this->method_title       = __( "Pagar.me - Bank Slip", "wc-pagarme-payments" );
        $this->method_description = __( "Pagar.me - Pay with bank slip", "wc-pagarme-payments" );

        $this->supports = [
            "products"
        ];

        $this->init_form_fields();
        $this->init_settings();

        $this->title       = $this->get_option( "title" );
        $this->description = $this->get_option( "description" );
        $this->enabled     = $this->get_option( "enabled" );
        $this->test_mode    = "yes" === $this->get_option( "test_mode" );

        add_action( 'woocommerce_thankyou_' . $this->id, [ $this, 'show_thankyou_page' ]);

        if ( is_admin() ) {
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, [ $this, 'process_admin_options' ] );
        }
        

        new Webhooks( $this->id, get_class( $this ) );

        parent::__construct();
    }

    /**
     * Create/Edit billet gateway options
     * @since 1.0.0
     * @return void
     */
    public function init_form_fields()
    {
        wp_enqueue_style( 'wpp-billet-page', Config::__dist( "styles/admin/pages/billet/index.css") );
        wp_enqueue_script( 'wpp-billet-page', Config::__dist( "scripts/admin/pages/billet/index.js") );
        
        $this->form_fields = [
            "enabled" => [
                "title"       => __( "Enable", "wc-pagarme-payments" ),
                "label"       => __( "Enable Gateway", "wc-pagarme-payments" ),
                "type"        => "checkbox",
                "description" => __( "Check this option to activate the payment method.", "wc-pagarme-payments" ),
                "default"     => "no",
                "desc_tip"    => true
            ],

            "test_mode" => [
                "title"       => __( "Test Mode", "wc-pagarme-payments" ),
                "label"       => __( "Enable test mode for bank slip.", "wc-pagarme-payments" ),
                "type"        => "checkbox",
                "description" => __( "Check this option to activate the test mode.", "wc-pagarme-payments" ),
                "default"     => "no",
                "desc_tip"    => true
            ],

            "title" => [
                "title"       => __( "Title", "wc-pagarme-payments" ),
                "type"        => "text",
                "description" => __( "This controls the title which the user sees during checkout.", "wc-pagarme-payments" ),
                "default"     => __( "Pagar.me Bank Slip", "wc-pagarme-payments" ),
                "desc_tip"    => true
            ],

            "description" => [
                "title"       => __( "Description", "wc-pagarme-payments" ),
                "type"        => "textarea",
                "description" => __( "This controls the description which the user sees during checkout.", "wc-pagarme-payments" ),
                "default"     => __( "Pay with bank slip using Pagar.me.", "wc-pagarme-payments" ),
                "desc_tip"    => true
            ],

            "bank" => [
                "title"       => __( "Bank", "wc-pagarme-payments" ),
                "type"        => "select",
                "description" => __( "This controls the witch bank generate the billet.", "wc-pagarme-payments" ),
                "options"     => [
                    "237" => "Banco Bradesco S.A.",
                    "341" => "Banco Itaú S.A.",
                    "033" => "Banco Santander S.A.",
                    "745" => "Banco Citibank S.A.",
                    "001" => "Banco Brasil S.A.",
                    "104" => "Caixa Econômica Federal",
                ],
                "desc_tip"    => true,
                "default"     => 237
            ],

            "expiration" => [
                "title"       => __( "Expiration days", "wc-pagarme-payments" ),
                "type"        => "number",
                "description" => __( "This controls the expiration days for bank slip.", "wc-pagarme-payments" ),
                "desc_tip"    => true,
                "default"     => 5
            ],

            "enabled_discount" => [
                "title"       => __( "Discount for bank slip payments", "wc-pagarme-payments" ),
                "label"       => __( "Enable dicount.", "wc-pagarme-payments" ),
                "type"        => "checkbox",
                "description" => __( "Check this option to activate the discount for bank slip payments.", "wc-pagarme-payments" ),
                "default"     => "no",
                "desc_tip"    => true
            ],

            "discount" => [
                "title"       => __( "Discount Value (%)", "wc-pagarme-payments" ),
                "type"        => "number",
                "description" => __( "This controls the value of discount for bank slip.", "wc-pagarme-payments" ),
                "desc_tip"    => true
            ],

            "logs" => [
                "title"       => __( "WooCommerce Logs", "wc-pagarme-payments" ),
                "label"       => __( "Enable bank slip logs.", "wc-pagarme-payments" ),
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
        ## Validade fields
        return true;
    }

    /**
     * Method override WPP\Services\WooCommerce\Gateways\Gateway::get_payment_method 
     * @since 1.0.0
     * @param object $wc_order
     * @return array
     */
    protected function get_payment_method( $wc_order )
    {
        $person     = $this->get_person();
        $expiration = $this->get_option( "expiration" );
        $date       = new DateTime();

        $date->add( new DateInterval( "P{$expiration}D" ) );
        
        return [
            [
                "amount"         => preg_replace( '/[^0-9]/', '', $wc_order->get_total() ),
                "payment_method" => "boleto",
                "boleto" => [
                    "bank"            => $this->get_option( "bank" ),
                    "instructions"    => "Pagar",
                    "due_at"          => $date->format( "Y-m-d\TH:i:s" ) . "Z",
                    "document_number" => $person['document'],
                    "type"            => "DM"
                ]
            ]
        ];
    }

    /**
     * Method override WPP\Services\WooCommerce\Gateways\Gateway::show_thankyou_page 
     * @since 1.0.0
     * @param int $wc_order_id
     * @return void
     */
    protected function show_thankyou_page( $wc_order_id )
    {
        
    }

    /**
     * Method override WPP\Services\WooCommerce\Gateways\Gateway::validade_response 
     * @since 1.0.0
     * @param object $response
     * @return bool
     */
    protected function validade_transaction( $charges, $wc_order )
    {
        global $woocommerce;

        $needed =  [ 'barcode', 'line', 'transaction_type', 'url', 'pdf', 'status' ];
        $metas  = [];

        foreach ( $charges as $charge ) {
            if ( isset( $charge->last_transaction ) ) {
                $transaction = (array) $charge->last_transaction;
                
                if ( array_intersect( $needed, array_keys( $transaction ) ) === $needed ) {
                    $metas['barcode']          = $transaction['barcode'];
                    $metas['billet_line']      = $transaction['line'];
                    $metas['billet_url']       = $transaction['url'];
                    $metas['billet_pdf']       = $transaction['pdf'];
                    $metas['transaction_type'] = $transaction['transaction_type'];
                    $metas['status']           = $transaction['status'];
                }

            }
        }
        
        if ( ! empty( $metas ) ){
            foreach ( $metas as $key => $meta ) {
                update_post_meta( $wc_order->get_id(), "wc-pagarme-$key", $meta );
            }

            $status = $this->get_woocommerce_status( $metas['status'] );

            $wc_order->update_status( $status, sprintf( "<strong>%s</strong> :", __( "Pagar.me: ", 'wc-pagarme-payments' ) ), true );

            wc_reduce_stock_levels( $wc_order->get_id() );

            $wc_order->add_order_note( sprintf( "<strong>%s</strong> : %s.",
                __( "Pagar.me: ", 'wc-pagarme-payments' ), 
                __( "Bank slip line: {$metas['billet_line']}", 'wc-pagarme-payments' )
            ), true );
            
            $wc_order->add_order_note( sprintf( "<strong>%s</strong> : %s", 
                __( "Pagar.me: ", 'wc-pagarme-payments' ), 
                __( "Awaiting the payment of the bank slip.", 'wc-pagarme-payments' )
            ), true );


            $woocommerce->cart->empty_cart();

            return true;
        }

        return false;
    }

}