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
    protected $body;
    protected $header;
    protected $method;
    protected $endpoint;

    /**
     * Send requests
     * @param array $header
     * @param array $body
     * @param string $url
     */
    protected function send()
    {
        $_header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $header = array_merge( $_header, $this->header );

        if ( ! $this->body ) {
            $this->body = [];
        }
        
        $args = [
            'headers' => $header,
            'timeout' => 10000,
            'body'    => json_encode($this->body),
            'method'  => $this->method
        ];

        $response = wp_remote_request( $this->endpoint, $args );

        return $response;
    }

    /**
     * Get the full request url
     * @param string $base
     * @param array $parameters
     * @return string
     */
    protected function get_endpoint( $base, $parameters = [] )
    {
        $url = Config::request_domain() . $base;
        foreach( $parameters as $param ) {
            if ( $param ) {
                $url .= "/{$param}";
            }
        }

        return $url;
    }
}
