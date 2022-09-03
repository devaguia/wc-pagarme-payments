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
    
    /**
     * Enqueue custom scripts and styles to the page
     * @return void
     */
    private function enqueue()
    {
        $this->enqueue_styles( [ 'name' => 'wpp-pix-checkout', 'file' => 'styles/theme/pages/checkout/pix.css' ] );
    }

    public function request()
    {
        $this->render( 'Pages/checkout/pix.php',[] );
        $this->enqueue();
    }
}