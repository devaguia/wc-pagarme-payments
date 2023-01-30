<?php

namespace WPP\Services\Pagarme\Requests;

use WPP\Services\Pagarme\Config;

/**
 * Abstract class for requests
 * @package Pagarme
 * @since 1.0.0
 */
abstract class Request 
{
    private array $body;
    private array $header;
    private string $method;
    private string $endpoint;
    private string $token;

    public function __construct()
    {
       $this->header     = [];
       $this->body       = [];
       $this->method     = "";
       $this->endpoint   = "";
       $this->token      = "";
    }


    protected function send()
    {
        $_header = [
            'Accept'         => 'application/json',
            'Content-Type'   => 'application/json',
            'Authorization'  => $this->token
        ];

        $header = array_merge( $_header, $this->header );
        
        $args = [
            'headers' => $header,
            'timeout' => 10000,
            'body'    => json_encode( $this->body ),
            'method'  => $this->method
        ];

        $url = $this->get_request_url( $this->endpoint );

        $response = wp_remote_request( $url, $args );
        
        if ( isset( $response['body'] ) ) {
            return $response['body'];
        }
    }


    protected function get_request_url( string $endpoint ): string
    {
        return Config::base_url() . "/$endpoint";
    }


    protected function set_body( array $body ): void
    {
        $this->body = $body;
    }


    protected function set_header( array $header ): void
    {
        $this->header = $header;
    }

    protected function set_method( string $method ): void
    {
        $this->method = $method;
    }


    protected function set_endpoint( string $endpoint ): void
    {
        $this->endpoint = $endpoint;
    }


    public function set_token( string $token ): void
    {
        $this->token = $token;
    }
}
