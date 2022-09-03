<?php

namespace WPP\Controllers\Entities;

/**
 * Name: Settings
 * @package Controller 
 * @since 1.0.0
 */
class Settings
{
    /**
     * Pagar.me production key
     * @var string
     */
    private $production_key;

    /**
     * Pagar.me test key
     * @var string
     */
    private $test_key;

    /**
     * Pagar.me payment methods
     * @var array
     */
    private $methods;

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


    public function __construct()
    {
    }

    /**
     * Get $production_key
     * @return string;
     */
    private function get_production_key()
    {
        return $this->production_key;
    }

    /**
     * Set $production_key
     * @param string $value
     * @return void
     */
    private function set_production_key( $value )
    {
        $this->production_key = $value;
    }

    /**
     * Get $test_key
     * @return string
     */
    private function get_test_key()
    {
        return $this->test_key;
    }

    /**
     * Set $production_key
     * @param string $value
     * @return void
     */
    private function set_test_key( $value )
    {
        $this->test_key = $value;
    }

    /**
     * Get $methods
     * @return array
     */
    private function get_methods()
    {
        return $this->methods;
    }

    /**
     * Set $methods
     * @param array $value
     * @return void
     */
    private function set_methods( $value )
    {
        $this->methods = $value;
    }

    /**
     * Get $credit_installments
     * @return array
     */
    private function get_credit_installments()
    {
        return $this->credit_installments;
    }

    /**
     * Set $production_key
     * @param array $value
     * @return void
     */
    private function set_credit_installments( $value )
    {
        $this->credit_installments = $value;
    }

    /**
     * Get $anti_fraud
     * @return bool
     */
    private function get_anti_fraud()
    {
        return $this->anti_fraud;
    }

    /**
     * Set $anti_fraud
     * @param bool $value
     * @return void
     */
    private function set_anti_fraud( $value )
    {
        $this->anti_fraud = $value;
    }

    /**
     * Get $anti_fraud_value
     * @return float
     */
    private function get_anti_fraud_value()
    {
        return $this->anti_fraud_value;
    }

    /**
     * Set $anti_fraud_value
     * @param float $value
     * @return void
     */
    private function set_anti_fraud_value( $value )
    {
        $this->anti_fraud_value = $value;
    }
}