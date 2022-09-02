<?php

namespace WPP\Controllers\Checkout;

use WPP\Controllers\Render\Render;

/**
 * Name: Render Checkout
 * Checkout field
 * @package Controller\Render
 * @since 1.0.0
 */
class Pix extends Render
{
    public function __construct()
    {
        $this->request();
    }
    
    public function request()
    {
        $this->render( 'Pages/checkout/pix.php',[] );
    }
}