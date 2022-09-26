<?php

namespace WPP\Core;

use WPP\Controllers\Menus\Installments;
use WPP\Controllers\Entities\Settings;
use WPP\Controllers\Menus;
use WPP\Model\Database\Bootstrap;
use WPP\Helpers\Config;
use WPP\Core\Uninstall;
use WPP\Model\Entity\Settings as EntitySettings;
use WPP\Services\WooCommerce\WooCommerce;

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
        load_plugin_textdomain( WPP_PLUGIN_SLUG , false );
    }

    /**
     * Create admin menu
     * @since 1.0.0
     * @return void
     */
    public static function create_admin_menu()
    {
        new Menus();
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

            $label = sprintf( '<a href="admin.php?page=pagarme" id="deactivate-wc-pagarme-payments" aria-label="%s">%s</a>',
                __( 'Payment setup plugin for Woocommerce', 'wc-pagarme-payments' ),
                __( 'Payment Settings', 'wc-pagarme-payments' )
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

    public static function ajax_get_installment_settings()
    {
        $settings = new Installments;
        return wp_send_json(
            [ 'content' => $settings->request() ],
            200
        );
    }


    public static function ajax_save_pagarme_settings()
    {
        $settings = new Settings;
        $settings->save();
        
        return wp_send_json(
            [ 'content' => $settings->get_response() ],
            $settings->get_status()
        );
    }
}