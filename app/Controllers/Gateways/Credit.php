<?php

namespace WPP\Controllers\Gateways;

use WC_Payment_Gateway;
use WPP\Controllers\Checkout\Checkout;
use WPP\Helpers\Config;
use WPP\Services\WooCommerce\Gateways\InterfaceGateways;
use WPP\Services\WooCommerce\Webhooks\Webhooks;

/**
 * Name: Billet
 * Structure the billet payment method
 * @package Controllers
 * @since 1.0.0
 */
class Credit extends WC_Payment_Gateway implements InterfaceGateways
{

    public function __construct() {
        
        $this->id                 = "wc-pagarme-credit";
        // $this->icon               = ## Image path 
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
        $this->testmode    = "yes" === $this->get_option( "testmode" );

        // add_action( 'woocommerce_thankyou_' . $this->id, [ $this, 'thank_you_page' ]);

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
                "default"     => __( "Payment setup plugin for Woocommerce", "wc-pagarme-payments" ),
                "desc_tip"    => true
            ],

            "description" => [
                "title"       => __( "Description", "wc-pagarme-payments" ),
                "type"        => "textarea",
                "description" => __( "This controls the description which the user sees during checkout.", "wc-pagarme-payments" ),
                "default"     => __( "Payment setup plugin for Woocommerce", "wc-pagarme-payments" ),
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

            if ( $this->testmode ) {

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
     * Handle gateway process payment
     * @since 1.0.0
     * @param int $wc_order_id
     * @return void
     */
    public function process_payment( $wc_order_id )
    {
        global $woocommerce;
        $wc_order = wc_get_order( $wc_order_id );
    }
}