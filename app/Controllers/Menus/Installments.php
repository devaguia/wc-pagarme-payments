<?php

namespace WPP\Controllers\Menus;

use WPP\Helpers\Utils;

/**
 * Name: Settings
 * @package Controller 
 * @since 1.0.0
 */
class Installments
{
    /**
     * Call the view render
     * @return void
     */
    public function request()
    {
        return Utils::render( 'Admin/credit/installments.php', [] );
    }
}