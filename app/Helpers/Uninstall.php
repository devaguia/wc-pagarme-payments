<?php

namespace WPP\Helpers;

use WPP\Model\Database\Bootstrap;

/**
 * Remove all tables and plugin data
 * 
 * @package Helper
 * @since 1.0.0
 */
class Uninstall // TODO create settings option for remove plugins data on remove him
{
    public function __construct()
    {
        $this->remove_tables();
    }
    

    private static function remove_tables(): void
    {
        $boot = new Bootstrap;
        $boot->uninstall();
    }
}