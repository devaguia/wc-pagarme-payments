<?php

namespace WPP\Controllers\Checkout;

use WPP\Controllers\Render\Render;

/**
 * Name: Render Checkout
 * Checkout field
 * @package Controller\Render
 * @since 1.0.0
 */
class Billet extends Render
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
        $this->enqueue_styles( [ 'name' => 'wpp-billet-checkout', 'file' => 'styles/theme/pages/checkout/billet.css' ] );
        $this->enqueue_scripts( [ 'name' => 'wpp-billet-checkout', 'file' => 'scripts/theme/pages/billet/checkout.js' ] );
    }
    
    public function request()
    {
        $this->render( 'Pages/checkout/billet.php',[] );
        $this->enqueue();
    }
}