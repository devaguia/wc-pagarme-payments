<?php

namespace WPP\Services\WooCommerce\Orders;

use WPP\Helpers\Utils;

/**
 * Name: Gateways
 * Create customs status
 * @package Services\WooCommerce
 * @since 1.0.0
 */
class Status 
{
	public function __construct()
	{
        add_action( 'init', [ $this, 'register_custom_statuses' ] );
        add_filter( 'wc_order_statuses', [ $this, 'add_custom_statuses' ], 10, 1 );
        add_action( 'woocommerce_order_status_changed', [ $this, 'on_status_changed' ], 10, 3 ); 
	}

    /**
     * Controller statuses
     * @since 1.0.0
     * @return array
     */
    private function get_new_status()
    {
        return [ 'wc-test-payment'  => __( 'Status test', WPP_PLUGIN_SLUG ) ];
    }

    /**
     * Register custom statuses
     * @since 1.0.0
     * @return void
     */
    public function register_custom_statuses()
    {
        $statuses = $this->get_new_status();

        foreach( $statuses as $key => $status ) {
            register_post_status( $key, [
                'label'                     => $status ,
                'public'                    => true,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true
            ] );
        }
    }

    /**
     * Add custom statuses
     * @since 1.0.0
     * @param array $order_statuses
     * @return array
     */
    public function add_custom_statuses( $order_statuses ) {

        $statuses = $this->get_new_status();
        $_order_statuses = [];

        foreach( $order_statuses as $key => $status ) {

            if ( ! array_intersect( $statuses, $_order_statuses ) ) {
                foreach( $statuses as $key => $status ) {
                    $_order_statuses[ $key ] = $status;
                }
            }

            $_order_statuses[ $key ] = $status;
        }

        return $_order_statuses;
    }

    /**
     * Filter when orders status change
     * @since 1.0.0
     * @param int $id
     * @param string $from
     * @param string $to
     * @return void
     */
    public function on_status_changed( $id, $from, $to )
    {
        $order = wc_get_order( $id );

        $payment_method  = $order->get_payment_method();
        $payment_methods = Utils::plugin_payment_methods();

        if ( array_intersect( $payment_methods, [ $payment_method ] ) ) {
            if ( $to === 'cancelled' ) {
                # Do something
            }
        }

    }

}