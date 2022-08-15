<?php

namespace WPP\Services\WooCommerce\Gateways;

/**
 * Name: Gateways
 * Register the Gateways
 * @package Services\WooCommerce
 * @since 1.0.0
 */
class Gateways 
{
	public function __construct()
	{
		$this->register_hooks();
	}

	/**
	 * Call the gateways woocommerce hooks
	 * @since 1.0.0
	 * @return void
	 */
	public function register_hooks()
	{
		add_filter( 'woocommerce_payment_gateways', [ $this, 'add_gateway_method' ] );
	}

	/**
	 * Create Gateways Options
	 * @since 1.0.0
	 * @param array $gateways
	 * @return array
	 */
	public function add_gateway_method( $gateways ) 
	{
        array_push( $gateways, 'WPP\Controllers\Gateways\Billet' );
        array_push( $gateways, 'WPP\Controllers\Gateways\Credit' );
        array_push( $gateways, 'WPP\Controllers\Gateways\Pix' );
        return $gateways;
	}
	
}