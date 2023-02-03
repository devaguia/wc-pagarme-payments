<?php

namespace WPP\Controllers\Checkout;

use WPP\Controllers\Gateways\Credit as GatewaysCredit;
use WPP\Controllers\Render\Render;
use WPP\Model\Entity\Settings;

/**
 * Render the credit card checkout fields
 * @package Controller\Render
 * @since 1.0.0
 */
class Credit extends Render
{
    public function __construct()
    {
        $this->request();
    }


    private function enqueue(): void
    {
        $this->enqueue_styles( [ 'name' => 'wpp-credit-checkout', 'file' => 'styles/theme/pages/checkout/credit.css' ] );
        $this->enqueue_scripts( [ 'name' => 'wpp-credit-checkout', 'file' => 'scripts/theme/pages/credit/checkout.js' ] );
    }


    private function get_installments_settings(): array
    {
        $model = new Settings( true );
        $installments = $model->get_single( 'credit_installments' );

        if ( isset( $installments->value ) && is_serialized( $installments->value ) ) {
            return unserialize( $installments->value );
        }

        return [];
    }


    private function get_installments(): array
    {
        $gateway = new GatewaysCredit;
        $max_installments = intval( $gateway->get_option("installments_quant") );

        $fees         = $this->get_installments_settings();
        $order_total  = WC()->cart->total;
        $installments = [];

        foreach ( $fees as $key => $fee ) {

            if ( $key <= $max_installments ) {
                $percent = $fee === 0 ? 0 : number_format( $fee, 1, '.', ',' );

                $value = $order_total / $key;
                $value = $value + ( ( $value * $fee ) / 100 );
                $value = "R$ " . number_format( $value, 2, ',', '.' );
    
                $label = $fee === 0  ? "{$key} x {$value} ( Sem de juros )" : "{$key} x {$value} ( {$percent}% de juros )";
    
                array_push( $installments, [
                    'installment' => $key,
                    'fee'         => $percent,
                    'value'       => $value,
                    'label'       => $label
                ] );
            }
        }

        return $installments;

    }


    private function get_public_key(): string
    {
        $model      = new Settings( true );
        $public_key = $model->get_single( 'public_key' );

        if ( isset( $public_key->value ) ) {
            return $public_key->value;
        }

        return "";
    }


    public function request(): void
    {
        $this->render( 'Pages/checkout/credit.php',[
            'installments' => $this->get_installments(),
            'public_key'   => $this->get_public_key()
        ] );

        $this->enqueue();
    }
}