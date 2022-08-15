<?php

namespace WPP\Services\Pagarme;

/**
 * Name: Authentication
 * Generate the athentication token
 * @package Pagarme
 * @since 1.0.0
 */
class Authentication 
{
    public function __construct()
    {
        $this->get_header();
        $this->get_payload();
    }
}
