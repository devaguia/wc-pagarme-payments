<?php
/**
 * Plugin Name: Pagarme Payments For WooCommerce
 * Plugin URI:  https://github.com/codebakerys/wc-pagarme-payments
 * Version:     1.0.0
 * Description: Payment plugin for Woocommerce/WooCommerce
 * Author:      Code Bakery
 * Author URI:  https://github.com/codebakerys
 *
 * @link    https://github.com/codebakerys/wc-pagarme-payments
 * @since   1.0.0
 * @package WPP
 */


require __DIR__ . '/vendor/autoload.php';

if ( version_compare( phpversion(), '7.4' ) < 0  ) {
	wp_die( sprintf( "%s <p>%s</p>",
			__( "The Pagarme Payments For WooCommerce isn't compatible to your PHP version. ", 'wc-pagarme-payments' ),
			__( "The PHP version has to be a less 7.4!", 'wc-pagarme-payments'  )
		),
		'Pagarme Payments For WooCommerce -- Error',
		[ 'back_link' => true ]
	);
}

require_once __DIR__ . '/app/index.php';
