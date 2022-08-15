<?php

namespace WPP\Controllers\Webhooks;

use WPP\Services\WooCommerce\Webhooks\InterfaceWebhooks;
/**
 * Name: Credit
 * Webhook for Credit payments
 * @package Controllers\Webhooks
 * @since 1.0.0
 */
class Credit implements InterfaceWebhooks
{

    public function __construct()
    {
        ## Do something
    }

    /**
     * Receive notifications
     * @since 1.0.0
     * @return void
     */
    public function handle_notifications()
    {
        ## Do something
    }
}