<?php

namespace WPP\Services\Pagarme\Webhooks;

use WPP\Model\Entity\Settings;

/**
 * Abstract class for webhooks classes
 * @package Services
 * @since 1.0.0
 */
abstract class Webhook
{
    protected object $data;
    protected Settings $settings;
    protected array $errors;

    public function get_errors(): array
    {
        return $this->errors;
    }
}