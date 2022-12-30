<?php

namespace WPP\Services\WooCommerce\Orders;

use WPP\Helpers\Config;
use WPP\Helpers\Utils;

/**
 * Name: Metabox
 * Create customs metabox
 * @package Services\WooCommerce
 * @since 1.0.0
 */
class Metabox 
{
	public function __construct()
	{
        add_action( 'add_meta_boxes', [ $this, 'wpp_log_meta_boxes' ] );
        add_action( 'save_post', [ $this, 'wpp_save_log_meta_boxes' ], 10, 1 );
	}

    /**
     * Add custom metabox
     * @since 1.0.0
     * @return void
     */
    public function wpp_log_meta_boxes()
    {
        add_meta_box( 'wpp_order_log_box', __( 'Pagar.me Order Logs', 'wc-pagarme-payments' ), [$this, 'wpp_add_order_log_content'], 'shop_order', 'advanced', 'core' );
    }

    /**
     * Show meta box content
     * @since 1.0.0
     * @return void
     */
    public function wpp_add_order_log_content()
    {
        global $post;

        wp_enqueue_style( 'global', Config::__dist( 'styles/global/index.css' ) );
        wp_enqueue_style( 'logs', Config::__dist( 'styles/admin/pages/logs/index.css' ) );
        
        echo Utils::render( 'Admin/orders/logs.php', [] );

    }

    /**
     * 
     */
    public function wpp_save_log_meta_boxes( $post_id )
    {

    }

}