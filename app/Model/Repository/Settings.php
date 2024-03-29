<?php

namespace WPP\Model\Repository;

use WPP\Model\InterfaceRepository;
use WPP\Model\Repository;
use Exception;

/**
 * Repository class for settings table
 * 
 * @package Model 
 * @since 1.0.0
 */
class Settings extends Repository implements InterfaceRepository
{
    /**
     * Find Pagar.me settings
     * 
     * @param string $key
     * @return array
     */
    public function find( $key = "" )
    {
        $fields = $key ? $this->find_by( $key ) : $this->find_all();

        if ( is_array( $fields ) ) {
            if ( empty( $fields ) ) {
                $this->save( $this->default() );
            }

            return $fields;
        }
    }

    /**
     * Find By
     * @param string $key
     * @return array
     */
    public function find_by( $key )
    {
        try {
            return $this->query( "SELECT `value` FROM {$this->prefix}wc_pagarme_settings WHERE `key` like '$key';" );
        } catch ( Exception $e ) {
            return [];
        }
    }

    /**
     * Find All
     * @param string $key
     * @return array
     */
    private function find_all()
    {
        try {
            return $this->query( "SELECT * FROM {$this->prefix}wc_pagarme_settings;" );
        } catch ( Exception $e ) {
            return [];
        }
    }
    

    /**
     * Save Pagar.me settings
     * @param array $fields
     * @return bool|array
     */
    public function save( $fields )
    {
        $errors = [];

        if ( ! empty( $fields ) ) {
            foreach ( $fields as $key => $value ) {
                if ( empty( $this->find_by( $key ) ) ) {
                    $result = $this->insert( $key, $value );
                } else {
                    $result = $this->update( $key, $value );
                }

                if ( $result === false ) {
                    array_push( $errors, $result );
                }
            }
        }

        if ( empty( $errors ) ) {
            return true;
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
        try {
            return $this->query( "UPDATE {$this->prefix}wc_pagarme_settings SET `value` = '$value' WHERE `key` like '$key';" );
        } catch ( Exception $e ) {
            return false;
        }
    }

    /**
     * Insert Pagar.me setting item
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function insert( $key, $value )
    {
        try {
            return $this->query( "INSERT INTO {$this->prefix}wc_pagarme_settings ( `key`, `value` ) VALUES ( '$key', '$value' );" );
        } catch ( Exception $e ) {
            return false;
        }
    }


    private function default(): array
    {
        return [
            'secret_key'           => "",
            'public_key'           => "",
            'payment_mode'         => "",
            'webhook_token'        => hash( "sha256", get_site_url() . time() ),
            'erase_settings'       => false,
            'credit_installments'  => serialize($this->get_default_credit_installments()),
            'success_status'       => "wc-processing"
        ];
    }


    private function get_default_credit_installments(): array
    {
        $installments = [];

        for ($i=1; $i < 25; $i++) { 
            $installments[$i] = 0;
        }

        return $installments;
    }
}