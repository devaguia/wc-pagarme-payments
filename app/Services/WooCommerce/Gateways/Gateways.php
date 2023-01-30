<?php

namespace WPP\Services\WooCommerce\Gateways;

/**
 * Register the Gateways
 * @package Services
 * @since 1.0.0
 */
class Gateways 
{
	public function __construct()
	{
		add_filter( 'woocommerce_payment_gateways', [ $this, 'add_gateway_method' ] );
	}


	public function add_gateway_method( array $gateways ): array
	{
        array_push( $gateways, 'WPP\Controllers\Gateways\Billet' );
        array_push( $gateways, 'WPP\Controllers\Gateways\Credit' );
        array_push( $gateways, 'WPP\Controllers\Gateways\Pix' );

        return $gateways;
	}
	
}