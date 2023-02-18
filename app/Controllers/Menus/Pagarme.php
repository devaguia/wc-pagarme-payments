<?php

namespace WPP\Controllers\Menus;

use WPP\Controllers\Render\Render;
use WPP\Helpers\Gateways;
use WPP\Model\Repository\Settings;

/**
 * Render Pagar.me settings page
 * 
 * @package Controller 
 * @since 1.0.0
 */
class Pagarme extends Render
{
    private array $fields;

    public function __construct()
    {
        $this->fields = [];
        $this->get_database_fields();
    }


    private function enqueue(): void
    {
        $this->enqueue_scripts( [ 'name' => 'wpp-admin', 'file' => 'scripts/admin/pages/pagarme/index.js' ] );
        $this->enqueue_styles( [ 'name' => 'wpp-admin', 'file' => 'styles/admin/pages/pagarme/index.css' ] );
    }


    private function default(): void
    {
        $this->fields = [
            'secret_key'          => '',
            'public_key'          => '',
            'payment_mode'        => '',
            'webhook_token'       => '',
            'erase_settings'      => '',
            'credit_installments' => [],
            'success_status'      => 'wc-processing',
        ];
    }


    private function get_database_fields(): void
    {
        $settings = new Settings;
        $fields   = $settings->find();

        $this->default();

        foreach ( $fields as $field ) {
            if ( isset( $field->key ) && isset( $field->value ) ) {
                if ( isset( $this->fields[$field->key] ) && $field->value ) {
                    $this->fields[$field->key] = $this->verify( $field->value );
                }
            }
        }

        $this->get_gateways();
        $this->get_statuses();
        $this->get_webhook_url();
        $this->get_payment_mode_label();
    }


    private function verify( $value )
    {
        if( is_serialized( $value ) ) {
            return unserialize( $value );
        }

        if ( $value === 'on' || $value === 'off' ) {
            return $value === 'on' ? true : false;
        }

        if ( is_numeric( $value ) ) {
            return intval( $value );
        }

        return $value;
    }


    private function get_gateways(): void
    {
        $methods = Gateways::pagarme_payment_methods();
        $this->fields['methods'] = ( is_array( $methods ) && ! empty( $methods ) ) ? $methods : [];
    }


    private function get_statuses(): void
    {
        $statuses = wc_get_order_statuses();
        $this->fields['statuses'] = ( is_array( $statuses ) && ! empty( $statuses ) ) ? $statuses : [];
    }

    private function get_webhook_url(): void
    {
        $token = $this->fields['webhook_token'];
        if ( $token ) {
            $this->fields['webhook_url'] = get_site_url() . "/index.php/wc-api/wc_pagarme_webhooks?token=$token";
        }
    }
    
    private function get_payment_mode_label(): void
    {
        if ( isset( $this->fields['payment_mode'] ) ) {
            switch ($this->fields['payment_mode']) {
                case 'test':
                    $this->fields['payment_mode_label'] = __( 'Test mode', 'wc-pagarme-payments' );
                    break;

                case 'production':
                    $this->fields['payment_mode_label'] = __( 'Production mode', 'wc-pagarme-payments' );
                    break;
                
                default:
                    $this->fields['payment_mode_label'] = "";
                    break;
            }
        }
    }

    public function request(): void
    {
        $this->render( 'Admin/settings/pagarme.php', $this->fields );
        $this->enqueue();
    }
}