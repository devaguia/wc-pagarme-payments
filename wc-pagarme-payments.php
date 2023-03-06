<?php
/**
 * Plugin Name: Pagar.me payments for WooCommerce
 * Plugin URI:  https://github.com/aguiarrdev/wc-pagarme-payments
 * Version:     1.0.1
 * Description: Payment plugin for WooCommerce/WordPress using the Pagar.me API
 * Author:      Matheus Aguiar
 * Author URI:  https://github.com/aguiarrdev
 *
 * @link    https://github.com/aguiarrdev/wc-pagarme-payments
 * @since   1.0.0
 * @package WPP
 */


require __DIR__ . '/vendor/autoload.php';

if ( version_compare( phpversion(), '7.4' ) < 0  ) {
	wp_die( sprintf( "%s <p>%s</p>",
			__( "The Pagar.me payments for WooCommerce isn't compatible to your PHP version. ", 'wc-pagarme-payments' ),
			__( "The PHP version has to be a less 7.4!", 'wc-pagarme-payments'  )
		),
		'Pagar.me payments for WooCommerce -- Error',
		[ 'back_link' => true ]
	);
}

require_once __DIR__ . '/app/index.php';
