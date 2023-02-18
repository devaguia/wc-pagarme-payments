<?php

namespace WPP\Helpers;

use WPP\Model\Database\Bootstrap;
use WPP\Model\Entity\Settings;

/**
 * Remove all tables and plugin data
 * 
 * @package Helper
 * @since 1.0.0
 */
class Uninstall 
{
    public function __construct()
    {
        $this->remove_tables();
    }

    private static function remove_tables(): void
    {
        $model = new Settings();

        if ( $model->get_erase_settings() ) {
            $boot = new Bootstrap;
            $boot->uninstall();
        }
    }
}