<?php

namespace WPP\Helpers;

/**
 * Name: Gateways
 * Has the statics methods
 * @package Helpers
 * @since 1.0.0
 */
class Gateways
{
    public static function pagarme_payment_methods()
    {
        $gateways = WC()->payment_gateways->payment_gateways();
        $needle   = [
            'wc-pagarme-billet',
            'wc-pagarme-credit',
            'wc-pagarme-pix'
        ];

        $methods = [];

        foreach ( $gateways as $key => $gateway ) {

            if ( in_array( $key, $needle ) ) {
                if ( isset( $gateway->settings ) ) {
                    $settings = $gateway->settings;

                    $methods[$key] = [
                        'active' => self::get_status( $settings ),
                        'label'  => self::get_title( $key ),
                        'mode'   => self::get_mode( $settings )
                    ];
                }
            }
        }

        return $methods;
    }

    private static function get_title( $method )
    {
        switch ($method) {
            case 'wc-pagarme-billet':
                $result = __( 'Bank Slip', 'wc-pagarme-payments' );
                break;
            
            case 'wc-pagarme-credit':
                $result = __( 'Credit Card', 'wc-pagarme-payments' );
                break;

            case 'wc-pagarme-pix':
                $result = __( 'Pix', 'wc-pagarme-payments' );
                break;
            default:
                $result = false;
                break;
        }

        return $result;
    }


    private static function get_mode( $settings )
    {
        $production = __( 'production', 'wc-pagarme-payments' );
        $sandbox    = __( 'sandbox', 'wc-pagarme-payments' );

        if ( isset( $settings['testmode'] ) ) {
            if ( $settings['testmode'] === 'yes' ) {
                return $production;
            }
        }

        return $sandbox;
    }

    private static function get_status( $settings )
    {
        if ( isset( $settings['enabled'] ) ) {
            if ( $settings['enabled'] === 'yes' ) {
                return true;
            }
        }

        return false;
    }
}