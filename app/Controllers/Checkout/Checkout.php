<?php

namespace WCPT\Controllers\Checkout;

use WCPT\Controllers\Render\Render;

/**
 * Name: Render Checkout
 * Checkout fields
 * @package Controller\Render
 * @since 1.0.0
 */
class Checkout extends Render
{
    public function request()
    {
        $this->render( 'templates/checkout/checkout.php',[] );
    }
}