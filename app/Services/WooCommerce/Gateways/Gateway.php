<?php

namespace WPP\Services\WooCommerce\Gateways;

use WC_Payment_Gateway;
use WPP\Model\Entity\Settings;
use WPP\Services\Pagarme\Authentication;
use WPP\Services\Pagarme\Requests\Orders\Create;
use WPP\Services\WooCommerce\Logs\Logger;

/**
 * Structure the billet payment method
 * @package Services
 * @since 1.0.0
 */
abstract class Gateway extends WC_Payment_Gateway 
{
    protected Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger;
    }


    public function process_payment($wc_order_id )
    {
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

        $authentication = new Authentication( get_class( $this ) );
        $token = $authentication->auth();

        $request->set_token( $token );

        $response = json_decode( $request->handle_request() );
        
        if ( $response ) {
            
            $this->logger->add( $response );

            if ( isset( $response->errors ) ) {
                $this->logger->add( [ $response->erros, $response->message ], 'error' );
                return $this->abort_payment_process( $response->message );
            }

            if ( isset ( $response->charges ) ) {
                if ( $this->validade_transaction( $response->charges, $wc_order ) ) {

                    $model = new Settings();

                    if ( $model->get_payment_mode() !== 'production' ) {
                        
                        $wc_order->add_order_note( sprintf( "<strong>%s</strong> : %s", 
                            __( "Pagar.me: ", 'wc-pagarme-payments' ), 
                            __( "Test mode activate! In this mode transactions are not real.", 'wc-pagarme-payments' )
                        ), true );
                    }

                    return array(
                        'result' => 'success',
                        'redirect' => $this->get_return_url( $wc_order )
                    );
                }
            }
        }
        

        return $this->abort_payment_process( __( 'Pagar.me: Failed to charge', 'wc-pagarme-payments' ) );

    }


    private function get_items( object $wc_order ): array
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


    private function get_address( object $wc_order )
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


    private function validate_address_fields( array $address ): bool
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


    private function get_customer( object $wc_order ): array
    {
        $billing_first_name = $wc_order->get_billing_first_name();
        $billing_last_name  = $wc_order->get_billing_last_name();

        $person_type = $this->get_person();


        $name     = "$billing_first_name $billing_last_name";
        $mail     = $wc_order->get_billing_email();
        $type     = $person_type['person'];
        $document = $person_type['document'];

        return [
            'name'     => $name,
            'email'    => $mail,
            'type'     => $type,
            'document' => $document
        ];

    }

    protected function get_person(): array
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


    private function get_phones( object $wc_order, array $phones = [] ): array
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


    private function get_order_shipping( object $wc_order, array $address, array $customer ): array
    {
        $shipping = [
            'amount'      => 0,
            'description' => __( "No shipping", "wc-pagarme-payment" ),
            'address'     => $address
        ];
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


    private function get_discounts( object $wc_order ): float
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


    private function get_taxes( object $wc_order ): float
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


    private function get_post_vars( string $var )
    {
        return isset( $_POST[$var] ) && ! empty( $_POST[$var] ) ? $_POST[$var] : false;
    }


    protected function get_woocommerce_status( string $original_status ): string
    {
        switch ( $original_status ) {
            case 'paid':
                $status = $this->get_success_status();
                break;

            case 'generated':
                $status = 'wc-on-hold';
                break;
            
            default:
                $status = 'wc-processing';
                break;
        }

        return $status;
    }


    protected function get_success_status(): string
    {
        $model = new Settings();
        return $model->get_success_status();
    }


    protected function abort_payment_process( string $message, string $type = "error" ): bool
    {
        wc_add_notice(  __( "Pagar.me: $message", 'wc-pagarme-payments' ), $type );
        return false;
    }


    abstract protected function get_payment_method( object $wc_order ): array;  

    abstract protected function validade_transaction( array $charges, object $wc_order ): bool;

    abstract public function show_thankyou_page( int $wc_order_id ): void;    

}