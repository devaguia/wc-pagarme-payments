<?php

namespace WPP\Services\WooCommerce\Gateways;

use WC_Payment_Gateway;
use WPP\Services\Pagarme\Requests\Orders\Create;

/**
 * Name: Billet
 * Structure the billet payment method
 * @package Controllers
 * @since 1.0.0
 */
abstract class Gateway extends WC_Payment_Gateway 
{
    /**
     * Handle gateway process payment
     * @since 1.0.0
     * @param int $wc_order_id
     * @return void
     */
    public function process_payment( $wc_order_id )
    {
        global $woocommerce;

        $wc_order = wc_get_order( $wc_order_id );
        
        $address  = $this->get_address( $wc_order );
        $customer = $this->get_customer( $wc_order );
        $phones   = $this->get_phones( $wc_order );
        $items    = $this->get_items( $wc_order );
        $payment  = $this->get_payment_method( $wc_order );
        $shipping = $this->get_order_shipping( $wc_order, $address, $customer );

        $request = new Create( $wc_order );

        $request->set_address( $address );
        $request->set_customer( $customer );
        $request->set_phones( $phones );
        $request->set_items( $items );
        $request->set_payment( $payment );
        $request->set_shipping( $shipping );

        // return $this->abort_process( "teste" );
        $response = $request->handle_request();
    }

    /**
     * Get order itens
     * @since 1.0.0
     * @param object $wc_order
     * @return array
     */
    private function get_items( $wc_order )
    {
        $items = [];
        $cart  = $wc_order->get_items();

        $discounts = $this->get_discounts( $wc_order );
        $taxes     = $this->get_taxes( $wc_order );

        foreach ( $cart as $key => $item ) {
            $product = $item->get_product();
            if ( $product ) {
                $total       = ( $product->get_price() + $taxes ) - $discounts;
                $amount      = preg_replace( '/[^0-9]/', '', number_format( $total, 2, ',', '.' ) );
                $description = $item->get_name();
                $quantity    = $item->get_quantity();
                $code        = "WC-{$product->get_id()}";
                
                array_push( $items, [
                    'amount'      => $amount,
                    'code'        => $code,
                    'description' => $description,
                    'quantity'    => $quantity
                ] );
            }
        }

        return $items;
    }

    /**
     * Get customer address
     * @since 1.0.0
     * @param object $wc_order
     * @return array
     */
    private function get_address( $wc_order )
    {
        $billing  = $wc_order->get_address( 'billing' );
        $shipping = $wc_order->get_address( 'shipping' );
        $address  = [];

        if ( $this->validate_address_fields( $shipping ) ) {
            $address = $shipping;
        }

        if ( $this->validate_address_fields( $billing ) ) {
            $address = $billing;
        }

        if ( ! empty( $address ) ) {
            $line     = "{$address['address_1']}, N° {$address['number']} - {$address['neighborhood']}";
            $postcode = preg_replace( '/[^0-9]/', '', $address['postcode'] );

            return [
                'line_1'   => $line,
                'line_2'   => $address['address_2'],
                'zip_code' => $postcode,
                'city'     => $address['city'],
                'state'    => $address['state'],
                'country'  => $address['country'],
            ];
        }


        $message = __( "Invalid address fields! Please check that the fields are filled in correctly.", "wc-pagarme-payments" );
        return $this->abort_payment_process( $message );
    }

    /**
     * Validade WooCommerce address fields
     * @since 1.0.0
     * @param array $address
     * @return bool
     */
    private function validate_address_fields( $address )
    {
        $needed = [ 'address_1', 'city', 'state', 'postcode', 'country', 'number', 'neighborhood' ];

        $validate = true;
        foreach ( $address as $key => $field ) {
            if ( in_array( $key, $needed ) ) {
                if ( ! $field ) $validate = false;
            }
        }

        return $validate;
    }

    /**
     * Get customer info fields
     * @since 1.0.0
     * @param object $wc_order
     * @return array
     */
    private function get_customer( $wc_order )
    {
        $billing_first_name = $wc_order->get_billing_first_name();
        $billing_last_name  = $wc_order->get_billing_last_name();

        $person_type = $this->get_person();


        $name     = "$billing_first_name $billing_last_name";
        $mail     = $wc_order->get_billing_email();
        $person   = $person_type['person'];
        $document = $person_type['document'];

        return [
            'name'     => $name,
            'email'    => $mail,
            'person'   => $person,
            'document' => $document
        ];

    }

    protected function get_person()
    {
        $billing_persontype  = $this->get_post_vars( 'billing_persontype' );
        $billing_cnpj        = $this->get_post_vars( 'billing_cnpj' );
        $billing_cpf         = $this->get_post_vars( 'billing_cpf' );

        $person = 'individual';
        if ( $billing_persontype ) {
            $person   = $billing_persontype == 1 ? 'individual' : 'company';
        }

        $document = $person === 'individual' ? preg_replace( '/[^0-9]/', '', $billing_cpf ) : preg_replace( '/[^0-9]/', '', $billing_cnpj );

        return [
            'person'   => $person,
            'document' => $document
        ];

    }

    /**
     * Get phone info
     * @since 1.0.0
     * @param object $wc_order
     * @param array $phones
     * @return array
     */
    private function get_phones( $wc_order, $phones = [] )
    {
        $billing_phone = $wc_order->get_billing_phone();
        if ( $billing_phone ) {
            $number      = $billing_phone ? str_replace( [ ' ', '(', ')', '-' ], '', $billing_phone ) : "";
            $area       = $number;
            
            $area        = $area ? preg_replace('/\A.{2}?\K[\d]+/', '', $area) : "";
            $number      = $number ? preg_replace('/^\d{2}/', '', $number)  : "";

            $phones['home_phone'] = [
                'country_code' => '55',
                'area_code'    => $area,
                'number'       => $number
            ];
        }


        $billing_cell  = $this->get_post_vars( 'billing_cellphone' );
        if ( $billing_cell ) {
            $number      = $billing_phone ? str_replace( [ ' ', '(', ')', '-' ], '', $billing_cell ) : "";
            $area       = $number;
            
            $area        = $area ? preg_replace('/\A.{2}?\K[\d]+/', '', $area) : "";
            $number      = $number ? preg_replace('/^\d{2}/', '', $number)  : "";

            $phones['mobile_phone'] = [
                'country_code' => '55',
                'area_code'    => $area,
                'number'       => $number
            ];
        }

        return $phones;
    }

    /**
     * Get order shipping
     * @since 1.0.0
     * @param object $wc_order
     * @return array
     */
    private function get_order_shipping( $wc_order, $address, $customer )
    {
        $shipping = [];
        $cart  = $wc_order->get_items( 'shipping' );

        foreach ( $cart as $key => $item ) {
            $amount          = preg_replace( '/[^0-9]/', '', $item->get_total() );
            $description     = $item->get_name();
            $address         = $address;
            $recipient_name  = $customer['name'];
            $recipient_phone = $wc_order->get_billing_phone();

            $shipping = [
                'amount'          => $amount,
                'description'     => $description,
                'address'         => $address,
                'recipient_name'  => $recipient_name,
                'recipient_phone' => $recipient_phone
            ];
        }

        return $shipping;
    }

    /**
     * Get order discounts
     * @since 1,0,0
     * @param object $wc_order
     * @return float
     */
    private function get_discounts( $wc_order )
    {
        $count = count( $wc_order->get_items() );
        $discount = 0;

        foreach( $wc_order->get_items('fee') as $item_id => $item_fee ){
            $total = floatval( $item_fee->get_total() );

            if ( $total < 0 ) {
                $discount += $total * -1;
            }
        }

        $discount += floatval( $wc_order->get_total_discount() );
        return $discount / $count;
    }

    /**
     * Get order taxes
     * @since 1.0.0
     * @param object $wc_order
     * @return float
     */
    private function get_taxes( $wc_order )
    {
        $count = count( $wc_order->get_items() );
        $taxes = 0;

        foreach( $wc_order->get_items('fee') as $item_id => $item_fee ){
            $total = floatval( $item_fee->get_total() );

            if ( $total > 0 ) {
                $taxes += $total;
            }
        }

        return $taxes / $count;
    }

    /**
     * Get payment method data
     * @since 1.0.0
     * @param object $wc_order
     * @return array
     */
    protected function get_payment_method( $wc_order )
    {
        return [];
    }

    /**
     * Get POST variables
     * @since 1.0.0
     * @param string $var
     * @return mixed|bool
     */
    private function get_post_vars( $var )
    {
        return isset( $_POST[$var] ) && ! empty( $_POST[$var] ) ? $_POST[$var] : false;
    }

    /**
     * Abort payment process
     * @since 1.0.0
     * @param string $message
     * @return bool
     */
    protected function abort_process( $message, $type = "error" )
    {
        wc_add_notice(  __( "Pagar.me: $message", 'wc-pagarme-payments' ), $type );
        return false;
    }
}