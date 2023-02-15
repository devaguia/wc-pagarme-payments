<?php

namespace WPP\Controllers\Gateways;

use WPP\Controllers\Checkout\Pix as Checkout;
use WPP\Controllers\Thankyou\Pix as ThankyouPix;
use WPP\Helpers\Config;
use WPP\Services\WooCommerce\Gateways\InterfaceGateways;
use WPP\Model\Entity\Settings;
use WPP\Services\WooCommerce\Gateways\Gateway;

/**
 * Structure the billet payment method
 * 
 * @package Controllers
 * @since 1.0.0
 */
class Pix extends Gateway implements InterfaceGateways
{
    public function __construct()
    {
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

        add_action( 'woocommerce_thankyou_' . $this->id, [ $this, 'show_thankyou_page' ]);

        if ( is_admin() ) {
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, [ $this, 'process_admin_options' ] );
        }

        parent::__construct();
    }


    public function init_form_fields(): void
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
        ## Validade fields
        return true;
    }


    protected function get_payment_method( object $wc_order ): array
    {
        return [
            [
                "amount" => preg_replace( '/[^0-9]/', '', $wc_order->get_total() ),
                "pix"    => [
                    "expires_in" => $this->get_option( "expiration" )
                ],
               "payment_method" => "pix"
            ]
        ];
    }


    public function show_thankyou_page( int $wc_order_id ): void
    {
        new ThankyouPix( $wc_order_id );
    }


    protected function validade_transaction( array $charges, object $wc_order ): bool
    {
        global $woocommerce;

        $needed =  [ 'qr_code', 'expires_at', 'transaction_type', 'qr_code_url', 'status' ];
        $metas  = [];

        foreach ( $charges as $charge ) {
            if ( isset( $charge->last_transaction ) ) {
                $transaction = (array) $charge->last_transaction;
                
                if ( array_intersect( $needed, array_keys( $transaction ) ) === $needed ) {
                    $metas['pix_qrcode']       = $transaction['qr_code'];
                    $metas['pix_url']          = $transaction['qr_code_url'];
                    $metas['pix_expiration']   = $transaction['expires_at'];
                    $metas['transaction_type'] = $transaction['transaction_type'];
                    $metas['status']           = $transaction['status'];
                }

            }
        }

        $disallowed_status = [ 'wc-failed', 'wc-cancelled' ];
        $status = $this->get_woocommerce_status( $metas['status'] );

        if ( ! empty( $metas ) && ! array_intersect( $disallowed_status, [ $status ] ) ) {
            foreach ( $metas as $key => $meta ) {
                update_post_meta( $wc_order->get_id(), "wc-pagarme-$key", $meta );
            }

            $status = $this->get_woocommerce_status( $metas['status'] );

            $wc_order->update_status( $status, sprintf( "<strong>%s</strong> :", __( "Pagar.me: ", 'wc-pagarme-payments' ) ), true );

            wc_reduce_stock_levels( $wc_order->get_id() );

            $wc_order->add_order_note( sprintf( "<strong>%s</strong> : %s.",
                __( "Pagar.me: ", 'wc-pagarme-payments' ), 
                __( "QRCode link: {$metas['pix_url']}", 'wc-pagarme-payments' )
            ), true );
            
            $wc_order->add_order_note( sprintf( "<strong>%s</strong> : %s", 
                __( "Pagar.me: ", 'wc-pagarme-payments' ), 
                __( "Awaiting the payment of the PIX transaction.", 'wc-pagarme-payments' )
            ), true );


            $woocommerce->cart->empty_cart();

            return true;
        }

        return false;
    }

}