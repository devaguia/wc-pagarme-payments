<?php

namespace WPP\Controllers\Thankyou;

use WPP\Controllers\Render\Render;

/**
 * Name: Render Pix thankyou page
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
        $this->enqueue_styles( [ 'name' => 'wpp-pix-thankyou', 'file' => 'styles/theme/pages/thankyou/pix.css' ] );
    }
    
    public function request()
    {
        $this->render( 'Pages/thankyou/pix.php',[] );
        $this->enqueue();
    }
}