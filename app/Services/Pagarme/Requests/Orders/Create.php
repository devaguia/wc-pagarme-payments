<?php

namespace WPP\Services\Pagarme\Requests\Orders;

use WPP\Services\Pagarme\Requests\InterfaceRequest;
use WPP\Services\Pagarme\Requests\Request;

/**
 * Name: Create
 * Create Pagarme Orders
 * @package Pagarme
 * @param int $order_id
 * @since 1.0.0
 */

class Create extends Request implements InterfaceRequest
{
    /**
     * @var array 
     */
    private $address;

    /**
     * @var array
     */
    private $customer;

    /**
     * @var array
     */
    private $phones;

    /**
     * @var array
     */
    private $items;

    /**
     * @var array
     */
    private $payment;

    /**
     * @var array
     */
    private $shipping;

    public function __construct( $wc_order )
    {
        $this->set_endpoint( "orders" );
        $this->set_method( "POST" );
    }

    public function handle_request()
    {
        $customer = $this->get_customer();

        $customer['address'] = $this->get_address();
        $customer['phones']  = $this->get_phones();

        $items    = $this->get_items();
        $payments = $this->get_payment();
        $shipping = $this->get_shipping();
        $body     = [
            'customer' => $customer,
            'items'    => $items,
            'payments' => $payments,
            'shipping' => $shipping
        ];

        $this->set_body( $body );


        return $this->send();
    }

    /**
     * Set address
     * @param array $address
     * @return void
     */
    public function set_address( $address )
    {
        $this->address = $address;
    }

    /**
     * Get address
     * @return array
     */
    public function get_address()
    {
        return $this->address;
    }

    /**
     * Set customer
     * @param array $customer
     * @return void
     */
    public function set_customer( $customer )
    {
        $this->customer = $customer;
    }

    /**
     * Get customer
     * @return array
     */
    public function get_customer()
    {
        return $this->customer;
    }

    /**
     * Set phones
     * @param array $phones
     * @return void
     */
    public function set_phones( $phones )
    {
        $this->phones = $phones;
    }

    /**
     * Get phones
     * @return array
     */
    public function get_phones()
    {
        return $this->phones;
    }

    /**
     * Set items
     * @param array $items
     * @return void
     */
    public function set_items( $items )
    {
        $this->items = $items;
    }

    /**
     * Get items
     * @return array
     */
    public function get_items()
    {
        return $this->items;
    }

    /**
     * Set payment
     * @param array $payment
     * @return void
     */
    public function set_payment( $payment )
    {
        $this->payment = $payment;
    }

    /**
     * Get payment
     * @return array
     */
    public function get_payment()
    {
        return $this->payment;
    }

    /**
     * Set shipping
     * @param array $shipping
     * @return void
     */
    public function set_shipping( $shipping )
    {
        $this->shipping = $shipping;
    }

    /**
     * Get shipping
     * @return array
     */
    public function get_shipping()
    {
        return $this->shipping;
    }
}