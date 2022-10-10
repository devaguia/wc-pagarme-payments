<?php

namespace WPP\Controllers\Menus;

use WPP\Controllers\Render\Render;
use WPP\Helpers\Gateways;
use WPP\Model\Repository\Settings;

/**
 * Name: Pagarme
 * @package Controller 
 * @since 1.0.0
 */
class Pagarme extends Render
{
    /**
     * @var array
     */
    private $fields;

    public function __construct()
    {
        $this->get_fields();
    }

    /**
     * Enqueue custom scripts and styles to the page
     * @return void
     */
    private function enqueue()
    {
        $this->enqueue_scripts( [ 'name' => 'wpp-admin', 'file' => 'scripts/admin/pages/pagarme/index.js' ] );
        $this->enqueue_styles( [ 'name' => 'wpp-admin', 'file' => 'styles/admin/pages/pagarme/index.css' ] );
    }

    /**
     * Set default values
     * @return void
     */
    private function default()
    {
        $this->fields = [
            'production_key'      => '',
            'test_key'            => '',
            'credit_installments' => [],
            'anti_fraud'          => false,
            'anti_fraud_value'    => 0,
            'success_status'      => 'wc-processing',
            'order_logs'          => false,
            'api_version'         => 1,
        ];
    }

    /**
     * Get fields from database
     * @return array
     */
    private function get_fields()
    {
        $settings = new Settings;
        $fields = $settings->find();

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
    }

    /**
     * Check if variable is serialized and unserialize
     * @return mixed
     */
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

    /**
     * Get gateways informations
     * @return void
     */
    private function get_gateways()
    {
        $methods = Gateways::pagarme_payment_methods();
        $this->fields['methods'] = ( is_array( $methods ) && ! empty( $methods ) ) ? $methods : [];
    }

    private function get_statuses()
    {
        $statuses = wc_get_order_statuses();
        $this->fields['statuses'] = ( is_array( $statuses ) && ! empty( $statuses ) ) ? $statuses : [];
    }
    
    /**
     * Call the view render
     * @return void
     */
    public function request()
    {
        $this->render( 'Admin/settings/pagarme.php', $this->fields );
        $this->enqueue();
    }
}