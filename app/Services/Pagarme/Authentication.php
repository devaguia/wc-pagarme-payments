<?php

namespace WPP\Services\Pagarme;

use WPP\Model\Entity\Settings;

/**
 * Name: Authentication
 * Generate the athentication token
 * @package Pagarme
 * @since 1.0.0
 */
class Authentication 
{
    /**
     * @var string
     */
    private $secret;

    /**
     * @var array
     */
    private $erros;

    public function __construct( $payment = "" )
    {
        $this->secret = "";
        $this->erros  = [];

        $this->set_secret( $payment );
    }

    /**
     * Make the basic authentication
     * @since 1.0.0
     * @return bool|string
     */
    public function auth()
    {
        if ( ! empty ( $this->erros ) ) {
            return false;
        }

        return "Basic " . base64_encode("$this->secret:");
    }

    /**
     * Get authentication erros array
     * @since 1.0.0
     * @return array
     */
    public function get_erros()
    {
        return $this->erros;
    }

    /**
     * Set the secret key 
     * @since 1.0.0
     * @param string $payment
     * @return void
     */
    private function set_secret( $payment )
    {
        if ( ! class_exists( $payment ) ) return;

        $class =  new $payment;
        $mode  = $class->get_option( "test_mode" ) === "yes" ? true : false;
        $model = new Settings( true );

        $option = $mode ? "production_key" : "test_key";
        $result = $model->get_single( $option );

        if ( isset( $result->value ) && $result->value ) {
            $this->secret = $result->value;
        } else {
            $this->erros[] = __( "Pagar.me: Unable to authenticate!", "wc-pagarme-payments" ); 
        }
        
    }
}
