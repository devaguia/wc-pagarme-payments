<?php

namespace WPP\Services\WooCommerce\Webhooks;

use WPP\Model\Options;

/**
 * Name: Woocommerce
 * Intance Woocommerce classes
 * @package Services\WooCommerce
 * @since 1.0.0
 */
class Webhooks 
{
	private $gateway;
	private $class;

	/**
	 * Class constructor
	 * @since 1.0.0
	 * @param string $gateways
     * @param string $class
	 */
	public function __construct( $gateway, $class )
	{
		$this->gateway = $gateway;
		$this->class   = $class;

		$webhook = $this->get_instance( $class );
		
		if ( $webhook ) {
			add_action( 'woocommerce_api_'. $this->get_endpoint(), [ $webhook, 'handle_notifications' ] );
		}
	}

	/**
	 * Get webhook endpoint
	 * @since 1.0.0
	 * @return string
	 */
	private function get_endpoint()
	{
		$option    = new Options;
		$settings  = $option->get_gateway_option( 'enable_webhook_token' );
		$token     = $option->get_gateway_option( 'webhook_token' );
		
		if ( $settings === 'yes' ) {
			return $token .= "-$this->gateway";
		}

		return $this->gateway;
	}

	/**
	 * Get class instance
	 * @since 1.0.0
	 * @return object|bool
	 */
	public function get_instance()
	{
		$classname = $this->class;

		if ( $pos = strrpos( $this->class, '\\' ) ) {
			$classname = substr($this->class, $pos + 1);
		}

		$instance = WPP_PLUGIN_NAMESPACE . "\\Controllers\\Webhooks\\{$classname}";

		if ( class_exists( $instance ) ) {
			return new $instance;
		}

		return false;
	}
	
}