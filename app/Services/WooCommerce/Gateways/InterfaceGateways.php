<?php

namespace WPP\Services\WooCommerce\Gateways;

/**
 * Name: Interface Gateways
 * Interface for requests
 * @package Services\WooCommerce
 * @since 1.0.0
 */
interface InterfaceGateways
{
    public function init_form_fields();
    public function payment_fields();
    public function validate_fields();
}