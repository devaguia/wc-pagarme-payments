<?php

namespace WPP\Controllers;

use stdClass;
use WPP\Model\Entity\Settings;
use WPP\Services\Pagarme\Webhooks\Orders;

/**
 * Handle Webhooks
 * 
 * @package Services
 * @since 1.0.0
 */
class Webhooks
{
    private Settings $settings;
    
    public function __construct()
    {
        $this->settings = new Settings();
        add_action('woocommerce_api_wc_pagarme_webhooks', [ $this, 'callback' ] );
    }


    public function callback()
    {
        $token = filter_input( INPUT_GET, 'token', FILTER_SANITIZE_SPECIAL_CHARS ) ?? '';
        $body  = json_decode( file_get_contents( 'php://input' ) );
    
        $this->check_webhook_token( $token );
        $this->filter_webhook_type( $body );
    }


    private function check_webhook_token( string $token ): bool
    {
        if ( $token && $this->settings->get_webhook_token() === $token ) {
            return true;
        }

        $this->return_unauthorized_access_error();
    }

    private function filter_webhook_type( $body ): void
    {
        $accepted_status = [
            'order.paid',
            'order.canceled',
            'order.payment_failed'
        ];

        $type = explode( '.', $this->get_webhook_type( $body ) );
        
        if ( ! in_array( join( '.', $type ) , $accepted_status ) ) {
            $this->return_invalid_type_error();
        }

        switch ( $type[0] ) {
            case 'order':
                $webhook = new Orders( $this->get_body_data( $body ), $this->settings );
                break;

            default:
                $webhook = false;
                break;
        }

        if ( $webhook ) {
            if ( ! empty ( $webhook->get_errors() ) ) {
                $error = array_pop( array_reverse( $webhook->get_errors() ) );
                $this->return_error( $error['code'], $error['message'] );
            }
        }
        
    }

    private function get_webhook_type( $body ): string
    {
        if ( isset( $body->type ) ) {
            return $body->type;
        }

        return '';
    }

    private function get_body_data( $body ): object
    {
        if ( isset( $body->data ) && is_object( $body->data ) ) {
            return $body->data;
        }

        return new stdClass;
    }


    private function return_invalid_type_error(): void
    {
        $this->return_error( 403, "Webhook type is invalid!" );
    }

    private function return_unauthorized_access_error(): void
    {
        $this->return_error( 401, "invalid access token!" );
    }

    private function return_error( int $code, string $message ): void
    {
        http_response_code($code);
        die(
            json_encode(
                [
                    "code"    => $code,
                    "message" => $message
                ]
            )
        );
    }
}