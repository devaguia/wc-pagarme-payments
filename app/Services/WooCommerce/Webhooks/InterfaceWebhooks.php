<?php

namespace WPP\Services\WooCommerce\Webhooks;

/**
 * Name: Interface Webhooks
 * Interface for requests
 * @package Services
 * @since 1.0.0
 */
interface InterfaceWebhooks
{
    public function handle_notifications();
}