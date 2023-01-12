<?php

namespace WPP\Controllers\Thankyou;

use WPP\Controllers\Render\Render;

/**
 * Name: Render Credit thankyou page
 * @package Controller\Render
 * @since 1.0.0
 */
class Credit extends Render
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
        $this->enqueue_styles( [ 'name' => 'wpp-credit-thankyou', 'file' => 'styles/theme/pages/thankyou/credit.css' ] );
    }
    
    public function request()
    {
        $this->render( 'Pages/thankyou/credit.php',[] );
        $this->enqueue();
    }
}