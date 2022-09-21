<?php

namespace WPP\Model\Repository;

use As247\WpEloquent\Support\Facades\DB;
use Exception;
use WPP\Model\InterfaceRepository;
use WPP\Model\Repository;

/**
 * Name: Settings
 * @package Model 
 * @since 1.0.0
 */
class Settings extends Repository implements InterfaceRepository
{
    /**
     * Find Pagar.me settings
     * @param string $key
     * @return array
     */
    public function find( $key = "" )
    {
        try {
            if ( $key ) {
                $fields = DB::table('wc_pagarme_setting' )->get()->toArray();
            } else {
                $fields = DB::table('wc_pagarme_setting' )->get()->toArray();
            }

            if ( is_array( $fields ) ) {
                if ( empty( $fields ) ) {
                    $this->save( $this->default() );
                }

                return $fields;
            }

        } catch ( Exception $e ) {
            $message = __( "Error getting the settings table ", "wc-pagarme-payments" );
            "$message {$e->getMessage()}";
        }
    }

    /**
     * Save Pagar.me settings
     * @param array $fields
     * @return bool|array
     */
    public function save( $fields )
    {
        if ( ! empty( $fields ) ) {
            foreach ( $fields as $key => $value ) {
                if ( empty( $this->find( $key ) ) ) {
                    return $this->insert( $key, $value );
                } else {
                    return $this->update( $key, $value );
                }
            }
        }

        return false;
    }

    /**
     * Update Pagar.me setting item
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function update( $key, $value )
    {
    }

    /**
     * Insert Pagar.me setting item
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function insert( $key, $value )
    {
    }

    /**
     * Get default settings
     * @return array
     */
    private function default()
    {
        return [
            'production_key'       => "",
            'test_key'             => "",
            'methods'              => [],
            'credit_installments'  => [],
            'anti_fraud'           => false,
            'anti_fraud_value'     => 0,
            'success_status'       => "processing",
            'order_log'            => false
        ];
    }
}