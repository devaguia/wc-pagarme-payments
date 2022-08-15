<?php

namespace WPP\Controllers\Webhooks;

/**
 * Name: Pix
 * Webhook for Pix payments
 * @package Controllers\Webhooks
 * @since 1.0.0
 */
class Pix implements InterfaceWebhooks
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