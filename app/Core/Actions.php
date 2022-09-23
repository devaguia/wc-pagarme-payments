<?php

namespace WPP\Core;

/**
 * Name: Actions
 * Call the actions and filters
 * @package Hooks
 * @since 1.0.0
 */

add_action( 'init', [ 
    Functions::class, 
    'initialize' 
] );

add_action( 'admin_menu', [ 
    Functions::class,
    'create_admin_menu' 
] );

add_action( 'activated_plugin', [
    Functions::class,
    'activate'
] );

add_action( 'woocommerce_init', [
    Functions::class,
    'woocommerce'
] );

add_filter( 'plugin_action_links', [
    Functions::class,
    'settings_link'
], 10, 2 );

add_action( 'wp_ajax_get_installment_settings', [
    Functions::class,
    'ajax_get_installment_settings'
], 999 );

add_action( 'wp_ajax_save_pagarme_settings', [
    Functions::class,
    'ajax_save_pagarme_settings'
], 999 );