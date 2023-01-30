<?php

namespace WPP\Services\WooCommerce\Orders;

use WPP\Helpers\Utils;

/**
 * Create custom status
 * @package Services
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


    private function get_new_status(): array
    {
        return [ 
            'wc-test-payment'  => __( 'Status test', "wc-pagarme-payments" ) 
        ];
    }


    public function register_custom_statuses(): void
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


    public function add_custom_statuses( array $order_statuses ): array
    {

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


    public function on_status_changed( int $id, string $from, string $to ): void
    {
        $order = wc_get_order( $id );

        $payment_method  = $order->get_payment_method();
        $payment_methods = Utils::active_payment_methods();

        if ( array_intersect( $payment_methods, [ $payment_method ] ) ) {
            if ( $to === 'cancelled' ) {
                # Do something
            }
        }

    }

}