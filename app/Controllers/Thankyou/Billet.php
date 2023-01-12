<?php

namespace WPP\Controllers\Thankyou;

use WPP\Controllers\Render\Render;

/**
 * Name: Render Billet thankyou page
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
        $this->enqueue_styles( [ 'name' => 'wpp-billet-thankyou', 'file' => 'styles/theme/pages/thankyou/billet.css' ] );
    }
    
    public function request()
    {
        $this->render( 'Pages/thankyou/billet.php',[] );
        $this->enqueue();
    }
}