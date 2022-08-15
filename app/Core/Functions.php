<?php

namespace WCPT\Core;

use WCPT\Controllers\Menus;
use WCPT\Model\Database\Bootstrap;
use WCPT\Helpers\Config;
use WCPT\Core\Uninstall;
use WCPT\Helpers\Utils;
use WCPT\Services\WooCommerce\WooCommerce;

/**
 * Name: Function
 * Handle the hooks functions
 * @package Core
 * @since 1.0.0
 */
class Functions
{
    /**
     * Load plugin text domain
     * @since 1.0.0
     * @return void
     */
    public static function initialize()
    {
        load_plugin_textdomain( WCPT_PLUGIN_SLUG , false );
    }

    /**
     * Create admin menu
     * @since 1.0.0
     * @return void
     */
    public static function create_admin_menu()
    {
        new Menus();
        register_deactivation_hook( __FILE__, self::desactive() );
    }

    /**
     * Init Woocommerce classes
     * @since 1.0.0
     * @return Woocommerce
     */
    public static function woocommerce()
    {
        return new WooCommerce;
    }

    /**
     * Create extra link on plugins page
     * @since 1.0.0
     * @param array $arr
     * @param string $name
     * @return array
     */
    public static function settings_link( $arr, $name ){

        if( $name === Config::__base() ) {

            $label = sprintf( '<a href="admin.php?page=wc-settings&tab=checkout&section=wc-plugin-template" id="deactivate-wc-plugin-template" aria-label="%s">%s</a>',
                __( 'Payment setup plugin for Woocommerce', 'wc-plugin-template' ),
                __( 'Payment Settings', 'wc-plugin-template' )
            );

            $arr['settings'] = $label;
        }

        return $arr;
    }

    /**
     * Activate plugin
     * @since 1.0.0
     * @return void|bool
     */
    public static function activate( $plugin )
    {
        if ( Config::__base() === $plugin ) {
            new Bootstrap;
        }
    }

    /**
     * Desactive the plugin
     * @since 1.0.0
     * @return void
     */
    public static function desactive() {
        new Uninstall;
    }
}