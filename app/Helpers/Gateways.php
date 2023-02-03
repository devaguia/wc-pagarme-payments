<?php

namespace WPP\Helpers;

/**
 * Pagar.me Gateways statics methods
 * @package Helpers
 * @since 1.0.0
 */
class Gateways
{

    public static function pagarme_payment_methods(): array
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
                if ( isset( $gateway->settings ) && is_array( $gateway->settings ) ) {
                    $settings = $gateway->settings;

                    $methods[$key] = [
                        'active' => self::get_gateway_status( $settings ),
                        'label'  => self::get_gateway_title( $key )
                    ];
                }
            }
        }

        return $methods;
    }


    public static function get_all_payment_methods(): array
    {
        $gateways = WC()->payment_gateways->payment_gateways();

        $methods = [];

        foreach ( $gateways as $key => $gateway ) {
            if ( isset( $gateway->settings ) && is_array( $gateway->settings ) ) {
                $settings = $gateway->settings;

                $methods[$key] = self::get_gateway_status( $settings ) ? 'active' : 'disabled';
            }
        }

        return $methods;
    }


    private static function get_gateway_title( string $method ): string
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
                $result = "";
                break;
        }

        return $result;
    }


    private static function get_gateway_status( array $settings ): bool
    {
        if ( isset( $settings['enabled'] ) ) {
            if ( $settings['enabled'] === 'yes' ) {
                return true;
            }
        }

        return false;
    }
}