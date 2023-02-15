<?php

namespace WPP\Controllers;

/**
 * Intance Woocommerce classes
 * 
 * @package Services
 * @since 1.0.0
 */
class Webhooks
{
    public function __construct()
    {
        add_action('woocommerce_api_wc_pagarme_webhooks', [ $this, 'callback' ] );
    }


    public function callback()
    {
        $token = filter_input( INPUT_GET, 'token', FILTER_SANITIZE_SPECIAL_CHARS ) ?? '';
        $body  = json_decode( file_get_contents( 'php://input' ) );
    
        $this->check_webhook_token( $token );

        error_log( var_export( "var", true ) );
        error_log( var_export( $_GET, true ) );
    }

    
    private function get_webhook_token(): string
    {
        return '';
    }


    private function check_webhook_token( string $token ): bool
    {
        if ( $token ) {
            return true;
        }

        $this->unauthorized_access_return();
    }


    private function unauthorized_access_return()
    {
        http_response_code(403);
        die(
            json_encode(
                [
                    "code"    => "403",
                    "message" => "invalid access token"
                ]
            )
        );
    }
}