<?php

namespace WPP\Controllers\Checkout;

use WPP\Controllers\Gateways\Credit as GatewaysCredit;
use WPP\Controllers\Render\Render;
use WPP\Model\Entity\Settings;

/**
 * Name: Render Checkout
 * Checkout field
 * @package Controller\Render
 * @since 1.0.0
 */
class Credit extends Render
{
    public function __construct()
    {
        $this->request();
    }

    /**
     * Enqueue custom scripts and styles to the page
     * @return void
     */
    private function enqueue()
    {
        $this->enqueue_styles( [ 'name' => 'wpp-credit-checkout', 'file' => 'styles/theme/pages/checkout/credit.css' ] );
        $this->enqueue_scripts( [ 'name' => 'wpp-credit-checkout', 'file' => 'scripts/theme/pages/credit/checkout.js' ] );
    }

    /**
     * Get installments from database
     * @since 1.0.0
     * @return array
     */
    private function get_installments_settings()
    {
        $model = new Settings( true );
        $installments = $model->get_single( 'credit_installments' );

        if ( isset( $installments['0'] ) ) {
            $installments = $installments['0'];

            if ( isset( $installments->value ) && is_serialized( $installments->value ) ) {
                return unserialize( $installments->value );
            }
        }

        return [];
    }

    /**
     * Get formatted installments
     * @since 1.0.0
     * @return array
     */
    private function get_installments()
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

    public function request()
    {
        $this->render( 'Pages/checkout/credit.php',[
            'installments' => $this->get_installments()
        ] );

        $this->enqueue();
    }
}