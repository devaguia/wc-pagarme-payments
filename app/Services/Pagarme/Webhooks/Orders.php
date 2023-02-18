<?php

namespace WPP\Services\Pagarme\Webhooks;

use WPP\Helpers\Gateways;
use WPP\Model\Entity\Settings;

/**
 * Orders Webhook class
 * 
 * @package Services
 * @since 1.0.0
 */
class Orders extends Webhook
{
    public function __construct( object $data, Settings $settings )
    {
        $this->data     = $data;
        $this->settings = $settings;
        $this->errors   = [];

        $this->handle_webhook_order_status();
    }

    private function handle_webhook_order_status(): void
    {
        if ( ! isset( $this->data->status ) ) {
            $this->errors[] = [
                'code' => 403,
                'message' => 'Order status is not set!'
            ];
            return;
        }

        $accepted_status = [
            'paid',
            'canceled',
            'payment_failed'
        ];

        if ( ! in_array( $this->data->status, $accepted_status ) ) {
            $this->errors[] = [
                'code' => 403,
                'message' => 'Invalid order status!'
            ];
            return;
        }

        switch ( $this->data->status ) {
            case 'paid':
                $this->set_woocommerce_order_paid();
                break;

            case 'canceled':
                $this->set_woocommerce_order_canceled();
                break;
            
            case 'payment_failed':
                $this->set_woocommerce_order_failed();
                break;
        }
    }

    private function get_webhook_wc_order_id(): int
    {
        if ( isset( $this->data->code ) ) {
            if ( stripos( $this->data->code, "WC-" ) === 0 ) {
                return intval( str_replace( 'WC-', '', $this->data->code ) );
            }
        }

        return 0;
    }

    private function get_webhook_pagarme_order_id(): string
    {
        if ( isset( $this->data->id ) ) {
            if ( stripos( $this->data->id, "or_" ) === 0 ) {
                return $this->data->id;
            }
        }

        $this->errors[] = [
            'code' => 403,
            'message' => 'Invalid Pagar.me order ID!'
        ];

        return '';
    }

    private function check_order_payment_gateway( $order ): bool
    {
        $gateways = array_keys( Gateways::pagarme_payment_methods() );

        if ( in_array( $order->get_payment_method(), $gateways ) ) {
            return true;
        }

        $this->errors[] = [
            'code' => 403,
            'message' => 'Your Pagar.me order code does not match a WooCommerce order!'
        ];
        
        return false;
    }

    private function set_woocommerce_order_paid(): void
    {
        $pagarme_order = $this->get_webhook_pagarme_order_id();

        $this->update_woocommerce_order_status( 
            $this->settings->get_success_status(),
            sprintf( "<strong>Pagar.me:</strong> %s <strong>$pagarme_order</strong> %s ",
                __( "Pagar.me order paid! Check the order", 'wc-pagarme-payments' ),
                __( "in your Pagar.me panel. \n", 'wc-pagarme-payments' )
            )
        );
    }

    private function set_woocommerce_order_canceled(): void
    {
        $pagarme_order = $this->get_webhook_pagarme_order_id();
        
        $this->update_woocommerce_order_status(
            'wc-canceled',
            sprintf( "<strong>Pagar.me:</strong> %s <strong>$pagarme_order</strong> %s ",
                __( "Pagar.me order canceled! Check the order", 'wc-pagarme-payments' ),
                __( "in your Pagar.me panel. \n", 'wc-pagarme-payments' )
            )
        );
    }

    private function set_woocommerce_order_failed(): void
    {
        $pagarme_order = $this->get_webhook_pagarme_order_id();
        
        $this->update_woocommerce_order_status(
            'wc-failed',
            sprintf( "<strong>Pagar.me:</strong> %s <strong>$pagarme_order</strong> %s ",
                __( "Pagar.me order failed! Check the order", 'wc-pagarme-payments' ),
                __( "in your Pagar.me panel. \n", 'wc-pagarme-payments' )
            )
        );
    }

    private function update_woocommerce_order_status( string $status, string $message ): void {
        $order_id = $this->get_webhook_wc_order_id();

        if ( $order_id === 0 ) {
            return;
        }

        $order = wc_get_order( $order_id );

        if ( $order && ! is_wp_error( $order ) ) {

            if ( $this->check_order_payment_gateway( $order ) ) {
                $order->update_status( $status, $message );
            }
        }
    }
}