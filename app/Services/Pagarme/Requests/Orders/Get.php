<?php

namespace WPP\Services\Pagarme\Requests\Orders;

use WPP\Services\Pagarme\Requests\InterfaceRequest;
use WPP\Services\Pagarme\Requests\Request;

/**
 * Name: Get
 * Get Pagarme Orders
 * @package Pagarme
 * @param int $order_id
 * @since 1.0.0
 */

class Get extends Request implements InterfaceRequest
{
    public function __construct( $order_id )
    {
    }

    public function handle_request()
    {
        return $this->send();
    }
}