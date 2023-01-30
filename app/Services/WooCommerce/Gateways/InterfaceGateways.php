<?php

namespace WPP\Services\WooCommerce\Gateways;

/**
 * Interface for payment methods classes
 * @package Services
 * @since 1.0.0
 */
interface InterfaceGateways
{
    public function init_form_fields(): void;
    public function payment_fields(): void;
    public function validate_fields(): bool;
}