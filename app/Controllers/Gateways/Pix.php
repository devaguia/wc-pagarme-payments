<?php

namespace WPP\Controllers\Gateways;

use WPP\Controllers\Checkout\Pix as Checkout;
use WPP\Helpers\Config;
use WPP\Services\WooCommerce\Gateways\InterfaceGateways;
use WPP\Controllers\Webhooks\Pix as Webhooks;
use WPP\Services\WooCommerce\Gateways\Gateway;

/**
 * Name: Billet
 * Structure the billet payment method
 * @package Controllers
 * @since 1.0.0
 */
class Pix extends Gateway implements InterfaceGateways
{

    public function __construct() {
        
        $this->id                 = "wc-pagarme-pix";
        $this->icon               = Config::__images( "icons/pix.svg");
        $this->has_fields         = false;
        $this->method_title       = __( "Pagar.me - Pix", "wc-pagarme-payments" );
        $this->method_description = __( "Pagar.me - Pay with pix", "wc-pagarme-payments" );

        $this->supports = [
            "products"
        ];

        $this->init_form_fields();
        $this->init_settings();

        $this->title       = $this->get_option( "title" );
        $this->description = $this->get_option( "description" );
        $this->enabled     = $this->get_option( "enabled" );
        $this->test_mode    = "yes" === $this->get_option( "test_mode" );

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
        wp_enqueue_style( 'wpp-pix-page', Config::__dist( "styles/admin/pages/pix/index.css") );
        wp_enqueue_script( 'wpp-pix-page', Config::__dist( "scripts/admin/pages/pix/index.js") );

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
                "label"       => __( "Enable test mode for pix payments.", "wc-pagarme-payments" ),
                "type"        => "checkbox",
                "description" => __( "Check this option to activate the test mode.", "wc-pagarme-payments" ),
                "default"     => "no",
                "desc_tip"    => true
            ],

            "title" => [
                "title"       => __( "Title", "wc-pagarme-payments" ),
                "type"        => "text",
                "description" => __( "This controls the title which the user sees during checkout.", "wc-pagarme-payments" ),
                "default"     => __( "Pagar.me PIX", "wc-pagarme-payments" ),
                "desc_tip"    => true
            ],

            "description" => [
                "title"       => __( "Description", "wc-pagarme-payments" ),
                "type"        => "textarea",
                "description" => __( "This controls the description which the user sees during checkout.", "wc-pagarme-payments" ),
                "default"     => __( "Pay with PIX using Pagar.me.", "wc-pagarme-payments" ),
                "desc_tip"    => true
            ],

            "expiration" => [
                "title"       => __( "Expiration time(seconds)", "wc-pagarme-payments" ),
                "type"        => "number",
                "description" => __( "This controls the time for QR code expiration.", "wc-pagarme-payments" ),
                "desc_tip"    => true,
                "default"     => 3500
            ],

            "enabled_discount" => [
                "title"       => __( "Discount for PIX payments", "wc-pagarme-payments" ),
                "label"       => __( "Enable dicount.", "wc-pagarme-payments" ),
                "type"        => "checkbox",
                "description" => __( "Check this option to activate the discount for PIX.", "wc-pagarme-payments" ),
                "default"     => "no",
                "desc_tip"    => true
            ],

            "discount" => [
                "title"       => __( "Discount Value (%)", "wc-pagarme-payments" ),
                "type"        => "number",
                "description" => __( "This controls the value of discount for PIX.", "wc-pagarme-payments" ),
                "desc_tip"    => true
            ],

            "logs" => [
                "title"       => __( "WooCommerce Logs", "wc-pagarme-payments" ),
                "label"       => __( "Enable pix logs.", "wc-pagarme-payments" ),
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
        return [
            [
                "amount" => $wc_order->get_total(), 
                "pix"    => [
                    "expires_in" => $this->get_option("expiration")
                ],
               "payment_method" => "pix"
            ]
        ];
    }
}