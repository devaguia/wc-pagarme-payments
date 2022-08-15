<?php

namespace WCPT\Core;

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
