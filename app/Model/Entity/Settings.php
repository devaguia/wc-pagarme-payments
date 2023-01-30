<?php

namespace WPP\Model\Entity;

use WPP\Model\Repository\Settings as Repository;

/**
 * Name: Settings
 * @package Controller 
 * @since 1.0.0
 */
class Settings
{
    /**
     * Pagar.me secret key
     * @var string
     */
    private $secret_key;

    /**
     * Pagar.me test key
     * @var string
     */
    private $public_key;

    /**
     * Pagar.me credit installments and fees
     * @var array
     */
    private $credit_installments;

    /**
     * Pagar.me anti fraud
     * @var bool
     */
    private $anti_fraud;

    /**
     * Pagar.me anti fraud value
     * @var float
     */
    private $anti_fraud_value;


    /**
     * WooCommerce success status
     * @var string
     */
    private $success_status;

    /**
     * WooCommerce Order logs
     * @var bool
     */
    private $order_logs;

    /**
     * Setting Repository
     * @var int
     */
    private $api_version;

    /**
     * Setting Repository
     * @var Repository
     */
    private $repository;

    private string $payment_mode;


    public function __construct( $single = false )
    {
        $this->repository = new Repository;
        if ( ! $single ) $this->fill();
    }

    /**
     * Fill the class fields
     * @return void
     */
    public function fill()
    {
        $fields = $this->repository->find();

        foreach ( $fields as $field ) {
            if ( ! isset( $field->key ) || ! isset( $field->value ) ) continue;
            
            switch ( $field->key ) {
                case 'secret_key':
                    $this->set_secret_key( $field->value );
                    break;
                
                case 'public_key':
                    $this->set_public_key( $field->value );
                    break;
            
                case 'credit_installments':
                    $this->set_credit_installments( unserialize( $field->value ) );
                    break;
                
                case 'anti_fraud':
                    $this->set_anti_fraud( $field->value );
                    break;
            
                case 'anti_fraud_value':
                    $this->set_anti_fraud_value( $field->value );
                    break;
        
                case 'success_status':
                    $this->set_success_status( $field->value );
                    break;
    
                case 'order_logs':
                    $this->set_order_logs( $field->value );
                    break;

                case 'api_version':
                    $this->set_api_version( $field->value );
                    break;
                case 'payment_mode':
                    $this->set_payment_mode( $field->value );
                    break;
            }
        }
    }

    /**
     * Save Paga.me Settings
     * @return void
     */
    public function save()
    {
       return $this->repository->save( $this->get_fields() );
    }

    /**
     * Get a single row on database
     * @param string $key
     * @return mixed
     */
    public function get_single( $key )
    {
        $reult = $this->repository->find( $key );
        if ( is_array( $reult ) && isset( $reult[0] ) ) {
            return $reult[0];
        }
        return ;
    }

    /**
     * Set a value for a single row on database
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function save_single( $key, $value )
    {
        return $this->repository->save( [ $key => $value ] );
    }

    /**
     * Get class propeties
     * @return array 
     */
    private function get_fields()
    {
        return [
            'secret_key'           => $this->get_secret_key(),
            'payment_mode'         => $this->get_payment_mode(),
            'public_key'           => $this->get_public_key(),
            'anti_fraud'           => $this->get_anti_fraud(),
            'anti_fraud_value'     => $this->get_anti_fraud_value(),
            'success_status'       => $this->get_success_status(),
            'order_logs'           => $this->get_order_logs(),
            'api_version'          => $this->get_api_version()
        ];
    }

    /**
     * Get $secret_key
     * @return string
     */
    public function get_secret_key()
    {
        return $this->secret_key;
    }

    /**
     * Set $secret_key
     * @param string $value
     * @return void
     */
    public function set_secret_key( $value )
    {
        $this->secret_key = $value;
    }

    /**
     * Get $public_key
     * @return string
     */
    public function get_public_key()
    {
        return $this->public_key;
    }

    /**
     * Set $secret_key
     * @param string $value
     * @return void
     */
    public function set_public_key( $value )
    {
        $this->public_key = $value;
    }

    /**
     * Get $credit_installments
     * @return array
     */
    public function get_credit_installments()
    {
        return $this->credit_installments;
    }

    /**
     * Set $secret_key
     * @param array $value
     * @return void
     */
    public function set_credit_installments( $value )
    {
        $this->credit_installments = $value;
    }

    /**
     * Get $anti_fraud
     * @return bool
     */
    public function get_anti_fraud()
    {
        return $this->anti_fraud;
    }

    /**
     * Set $anti_fraud
     * @param bool $value
     * @return void
     */
    public function set_anti_fraud( $value )
    {
        $this->anti_fraud = $value;
    }

    /**
     * Get $anti_fraud_value
     * @return float
     */
    public function get_anti_fraud_value()
    {
        return $this->anti_fraud_value;
    }

    /**
     * Set $anti_fraud_value
     * @param float $value
     * @return void
     */
    public function set_anti_fraud_value( $value )
    {
        $this->anti_fraud_value = $value;
    }

    /**
     * Get $success_status
     * @return string
     */
    public function get_success_status()
    {
        return $this->success_status;
    }

    /**
     * Set $success_status
     * @param string $value
     * @return void
     */
    public function set_success_status( $value )
    {
        $this->success_status = $value;
    }

    /**
     * Get $order_logs
     * @return bool
     */
    public function get_order_logs()
    {
        return $this->order_logs;
    }

    /**
     * Set $order_logs
     * @param bool $value
     * @return void
     */
    public function set_order_logs( $value )
    {
        $this->order_logs = $value;
    }

    /**
     * Get $api_version
     * @return int
     */
    public function get_api_version()
    {
        return $this->api_version;
    }

    /**
     * Set $api_version
     * @param int $value
     * @return void
     */
    public function set_api_version( $value )
    {
        $this->api_version = $value;
    }


    public function get_payment_mode(): string
    {
        return $this->payment_mode;
    }


    public function set_payment_mode( string $value ): void
    {
        $this->payment_mode = $value;
    }
}