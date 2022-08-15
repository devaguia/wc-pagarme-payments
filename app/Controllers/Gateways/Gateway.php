<?php

namespace WCPT\Controllers\Gateways;

use WC_Payment_Gateway;
use WCPT\Controllers\Checkout\Checkout;
use WCPT\Services\WooCommerce\Gateways\InterfaceGateways;
use WCPT\Services\WooCommerce\Webhooks\Webhooks;

/**
 * Name: Billet
 * Structure the billet payment method
 * @package Controllers
 * @since 1.0.0
 */
class Gateway extends WC_Payment_Gateway implements InterfaceGateways
{

    public function __construct() {
        
        $this->id                 = "wc-plugin-template";
        // $this->icon               = ## Image path 
        $this->has_fields         = false;
        $this->method_title       = __( "Gateway Example", WCPT_PLUGIN_SLUG );
        $this->method_description = __( "Payment gateway example", WCPT_PLUGIN_SLUG );

        $this->supports = [
            "products"
        ];

        $this->init_form_fields();
        $this->init_settings();

        $this->title       = $this->get_option( "title" );
        $this->description = $this->get_option( "description" );
        $this->enabled     = $this->get_option( "enabled" );
        $this->testmode    = "yes" === $this->get_option( "testmode" );
        $this->secret_key  = $this->testmode ? $this->get_option( "test_secret_key" ) : $this->get_option( "secret_key" );

        add_action( 'woocommerce_thankyou_' . $this->id, [ $this, 'caos_thank_you_page' ]);

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

        $this->form_fields = [
            "enabled" => [
                "title"       => __( "Enable", WCPT_PLUGIN_SLUG ),
                "label"       => __( "Enable Gateway", WCPT_PLUGIN_SLUG ),
                "type"        => "checkbox",
                "description" => __( "Check this option to activate the payment method", WCPT_PLUGIN_SLUG ),
                "default"     => "no",
                "desc_tip"    => true
            ],

            "title" => [
                "title"       => __( "Title", WCPT_PLUGIN_SLUG ),
                "type"        => "text",
                "description" => __( "This controls the title which the user sees during checkout.", WCPT_PLUGIN_SLUG ),
                "default"     => __( "Payment setup plugin for Woocommerce", WCPT_PLUGIN_SLUG ),
                "desc_tip"    => true
            ],

            "description" => [
                "title"       => __( "Description", WCPT_PLUGIN_SLUG ),
                "type"        => "textarea",
                "description" => __( "This controls the description which the user sees during checkout.", WCPT_PLUGIN_SLUG ),
                "default"     => __( "Payment setup plugin for Woocommerce", WCPT_PLUGIN_SLUG ),
                "desc_tip"    => true
            ]
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

                $this->description .= __( " Test mode activate! In this mode transactions are not real.", WCPT_PLUGIN_SLUG );
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