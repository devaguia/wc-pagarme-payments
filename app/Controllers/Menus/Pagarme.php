<?php

namespace WPP\Controllers\Menus;

use WPP\Controllers\Render\Render;

/**
 * Name: Pagarme
 * @package Controller 
 * @since 1.0.0
 */
class Pagarme extends Render
{
    /**
     * Enqueue custom scripts and styles to the page
     * @return void
     */
    private function enqueue()
    {
        $this->enqueue_scripts( [ 'name' => 'wpp-admin', 'file' => 'scripts/admin/pages/pagarme/index.js' ] );
        $this->enqueue_styles( [ 'name' => 'wpp-admin', 'file' => 'styles/admin/pages/pagarme/index.css' ] );
    }
    
    /**
     * Call the view render
     * @return void
     */
    public function request()
    {
        $this->render( 'Admin/settings/pagarme.php', [] );
        $this->enqueue();
    }
}