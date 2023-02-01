<?php

namespace WPP\Helpers;

use WPP\Model\Database\Bootstrap;

/**
 * Name: Uninstall
 * Remove all tables and plugin data
 * @package Helper
 * @since 1.0.0
 */
class Uninstall // TODO create settings option for remove plugins data on remove him
{
    public function __construct()
    {
        $this->removeTables();
    }
    
    /**
     * Remove all tables created by the plugin
     * @since 1.0.0
     * @return void
     */
    private static function removeTables()
    {
        $boot = new Bootstrap;
        $boot->uninstall();
    }
}