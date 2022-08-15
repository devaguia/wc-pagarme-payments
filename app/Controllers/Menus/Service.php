<?php

namespace WCPT\Controllers\Menus;

use WCPT\Controllers\Render\Render;

/**
 * Name: About
 * @package Controller 
 * @since 1.0.0
 */
class Service extends Render
{
    /**
     * Enqueue custom scripts and styles to the page
     * @return void
     */
    private function enqueue()
    {
        $this->enqueue_scripts( [ 'name' => 'wc-admin', 'file' => 'scripts/admin/pages/service/index.js' ] );
        $this->enqueue_styles( [ 'name' => 'wc-admin', 'file' => 'styles/admin/pages/service/index.css' ] );
    }
    
    /**
     * Call the view render
     * @return void
     */
    public function request()
    {
        $this->render( 'Admin/service.php', [] );
        $this->enqueue();
    }
}