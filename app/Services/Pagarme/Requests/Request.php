<?php

namespace WPP\Services\Pagarme\Requests;

use WPP\Services\Pagarme\Config;

/**
 * Name: Request
 * Abstract class for requests
 * @package Pagarme
 * @since 1.0.0
 */
abstract class Request 
{
    /**
     * @var array
     */
    private $body;

    /**
     * @var array
     */
    private $header;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var string
     */
    private $token;

    /**
     * Send requests
     * @param array $header
     * @param array $body
     * @param string $url
     */
    protected function send()
    {
        if ( ! $this->body ) $this->body     = [];
        if ( ! $this->header ) $this->header = [];


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

    /**
     * Get the full request url
     * @param string $base
     * @param array $parameters
     * @return string
     */
    protected function get_request_url( $endpoint )
    {
        return Config::base_url() . "/$endpoint";
    }

    /**
     * Set body
     * @param array $body
     */
    protected function set_body( $body )
    {
        $this->body = $body;
    }


    /**
     * Set header
     * @param array $header
     */
    protected function set_header( $header )
    {
        $this->header = $header;
    }

    /**
     * Set method
     * @param array $method
     */
    protected function set_method( $method )
    {
        $this->method = $method;
    }

    /**
     * Set endpoint
     * @param array $endpoint
     */
    protected function set_endpoint( $endpoint )
    {
        $this->endpoint = $endpoint;
    }


    /**
     * Set token
     * @param array $token
     */
    public function set_token( $token )
    {
        $this->token = $token;
    }
}
