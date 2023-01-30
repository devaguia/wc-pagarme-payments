<?php

namespace WPP\Services\WooCommerce\Webhooks;

use WPP\Model\Options;

/**
 * Intance Woocommerce classes
 * @package Services
 * @since 1.0.0
 */
class Webhooks 
{
	private string $gateway;
	private string $class;

	public function __construct( string $gateway, string $class )
	{
		$this->gateway = $gateway;
		$this->class   = $class;

		$webhook = $this->get_webhook_instance( $class );
		
		if ( $webhook ) {
			// add_action( 'woocommerce_api_'. $this->get_endpoint(), [ $webhook, 'handle_notifications' ] );
		}
	}


	private function get_webhook_endpoint(): string
	{
		$option    = new Options;
		$settings  = $option->get_gateway_option( 'enable_webhook_token' );
		$token     = $option->get_gateway_option( 'webhook_token' );
		
		if ( $settings === 'yes' ) {
			return $token .= "-$this->gateway";
		}

		return $this->gateway;
	}


	public function get_webhook_instance()
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