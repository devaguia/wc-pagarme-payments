<?php

namespace WPP\Services\Pagarme;

/**
 * Name: Config
 * Handles general service information
 * @package Pagarme
 * @since 1.0.0
 */
class Config
{
    /**
     * Sandbox URL
     * @since 1.0.0
     */
    const WKO_SANDBOX_DOMAIN = '';

    /**
     * Production URL
     * @since 1.0.0
     */
    const WKO_PRODUCTION_DOMAIN = '';

    /**
     * Gets the selected mode
     * @since 1.0.0
     * @return boolean
     */
    public function selected_mode()
    {
        return true;
    }

    /**
     * Get url for the selected mode
     * @since 1.0.0
     * @return string
     */
    public static function request_domain()
    {
        return '';
    }

    /**
     * Get base url for the selected mode
     * @since 1.0.0
     * @return string
     */
    public static function base_url()
    {
        return 'https://api.pagar.me/core/v5/';
    }

    /**
     * Get secret key
     * @since 1.0.0
     * @return string
     */
    public static function secret_key()
    {
        return '';
    }

    /**
     * Get secret key
     * @since 1.0.0
     * @return string
     */
    public static function consumer_key()
    {
        return '';
    }
}