<?php

namespace WPP\Services\WooCommerce;

use WPP\Services\WooCommerce\Checkout\Discount;
use WPP\Services\WooCommerce\Gateways\Gateways;
use WPP\Services\WooCommerce\Orders\Status;

/**
 * Intance Woocommerce classes
 * @package Controllers
 * @since 1.0.0
 */
class WooCommerce 
{
	public function __construct()
	{
		$this->instance_woocommerce_controllers();
	}

	private function instance_woocommerce_controllers(): void
	{  
        new Gateways;
        new Status;
		new Discount;
	}
}