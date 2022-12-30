<?php

namespace WPP\Services\WooCommerce;

use WPP\Services\WooCommerce\Gateways\Gateways;
use WPP\Services\WooCommerce\Orders\Metabox;
use WPP\Services\WooCommerce\Orders\Status;

/**
 * Name: Woocommerce
 * Intance Woocommerce classes
 * @package Controllers
 * @since 1.0.0
 */
class WooCommerce 
{
	public function __construct()
	{
		$this->instance_main_controllers();
		$this->instance_order_controllers();
	}

	/**
	 * Call main controllers classes
	 * @since 1.0.0
	 * @return void
	 */
	private function instance_main_controllers()
	{  
        new Gateways;
        new Status;
		new Metabox;
	}

	/**
	 * Call order controllers classes
	 * @since 1.0.0
	 * @return void
	 */
    private function instance_order_controllers()
    {
		## Call order controller class
    }
	
}