<?php

namespace WPP\Core;

use WPP\Controllers\Entities\Installments as EntitiesInstallments;
use WPP\Controllers\Menus\Installments;
use WPP\Controllers\Entities\Settings;
use WPP\Controllers\Menus;
use WPP\Model\Database\Bootstrap;
use WPP\Helpers\Config;
use WPP\Helpers\Export;
use WPP\Helpers\Uninstall;
use WPP\Services\WooCommerce\WooCommerce;

/**
 * Handle the hooks functions
 * 
 * @package Core
 * @since 1.0.0
 */
class Functions
{
    public static function initialize(): void
    {
        load_plugin_textdomain( WPP_PLUGIN_SLUG , false );
    }


    public static function create_admin_menu(): void
    {
        new Menus();
    }


    public static function woocommerce(): void
    {
        new WooCommerce;
    }


    public static function settings_link( array $arr, string $name ): array
    {

        if( $name === Config::__base() ) {

            $label = sprintf( '<a href="admin.php?page=pagarme" id="deactivate-wc-pagarme-payments" aria-label="%s">%s</a>',
                __( 'Payment setup plugin for Woocommerce', 'wc-pagarme-payments' ),
                __( 'Payment Settings', 'wc-pagarme-payments' )
            );

            $arr['settings'] = $label;
        }

        return $arr;
    }


    public static function activate( string $plugin ): void
    {
        if ( Config::__base() === $plugin ) {
            new Bootstrap;
        }
    }


    public static function desactive(): void
    {
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


    public static function ajax_save_pagarme_installments()
    {
        $settings = new EntitiesInstallments;
        $settings->save();
        
        return wp_send_json(
            [ 'content' => $settings->get_response() ],
            $settings->get_status()
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


    public static function ajax_export_settings_file()
    {
        $export = new Export;
        $data   = $export->get_data();

        return wp_send_json(
            [ 
                'content' => [ 'file' => $data ] 
            ],
            200
        );
    }
}