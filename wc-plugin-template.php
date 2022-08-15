<?php
/**
 * Plugin Name: Payment Plugin Template
 * Plugin URI:  https://github.com/codebakerys/wc-plugin-template
 * Version:     1.0.0
 * Description: Payment template plugin for Woocommerce/WooCommerce
 * Author:      Code Bakery
 * Author URI:  https://github.com/codebakerys
 *
 * @link    https://github.com/codebakerys/wc-plugin-template
 * @since   1.0.0
 * @package WCPT
 */


require __DIR__ . '/vendor/autoload.php';

if ( version_compare( phpversion(), '7.4' ) < 0  ) {
	wp_die( sprintf( "%s <p>%s</p>",
			__( "The WooCommerce Plugin Template isn't compatible to your PHP version. ", 'wc-plugin-template' ),
			__( "The PHP version has to be a less 7.4!", 'wc-plugin-template'  )
		),
		'WooCommerce Plugin Template -- Error',
		[ 'back_link' => true ]
	);
}

require_once __DIR__ . '/app/index.php';
