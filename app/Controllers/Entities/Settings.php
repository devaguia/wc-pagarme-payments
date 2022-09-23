<?php

namespace WPP\Controllers\Entities;

use WPP\Helpers\Utils;
use WPP\Model\Entity\Settings as Model;

/**
 * Name: Settings
 * @package Controller 
 * @since 1.0.0
 */
class Settings
{
    /**
     * @var array
     */
    private $propeties;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $response;

    public function __construct()
    {
        $this->sanitize_vars();
    }

    /**
     * Save settings
     * @return void
     */
    private function save()
    {
        $model = new Model();

        $model->set_api_version( $this->propeties['wpp-pagarme-api-version'] );
        $model->set_production_key( $this->propeties['wpp-production-secret-key'] );
        $model->set_test_key( $this->propeties['wpp-test-secret-key'] );
        $model->set_success_status( $this->propeties['finish-order-status'] );
        $model->set_anti_fraud( $this->propeties['wpp-anti-fraud'] );
        $model->set_anti_fraud_value( $this->propeties['wpp-anti-fraud-value'] );
        $model->set_order_log( $this->propeties['wpp-order-log'] );
        $model->set_methods( $this->propeties['wpp-payment-methods'] );

        $result = $model->save();

        if ( $result ) { 
            $this->status   = 200;
            $this->response = [
                'message' => __( "Settings saved successfully!", "wc-pagarme-settings" )
            ];

        } else {
            $this->status   = 400;
            $this->response = [
                'message' => __( "Could not save the settings!", "wc-pagarme-settings" )
            ];
        }
    }

    /**
     * Get active payment methods
     * @return void
     */
    private function get_payment_methods()
    {
        $default = [
            'wc-pagarme-billet' => false,
            'wc-pagarme-credit' => false,
            'wc-pagarme-pix'    => false,
        ];

        $methods = Utils::active_payment_methods();

        foreach ( $default as $key => $value ) {
            if ( isset( $methods[$key] ) ) {
                $methods[$key] = true;
            }
        }

        $this->propeties['wpp-payment-methods'] = serialize( $methods );
    }

    /**
     * Sanitize propeties vars
     * @return void
     */
    private function sanitize_vars()
    {
        $vars = isset( $_POST['action'] ) && $_POST['action'] === 'save_pagarme_settings' ? $_POST : [];

        if ( ! empty( $vars ) ) {
            $needed = [ 
                'wpp-finish-order-status',
                'wpp-production-secret-key',
                'wpp-test-secret-key',
                'wpp-anti-fraud-value',
                'wpp-pagarme-api-version',
                'wpp-order-logs',
                'wpp-anti-fraud'
            ];

            foreach ( $vars as $key => $var ) {
                $key = str_replace( "wpp-", "", $key );

                if( in_array( $key, $needed ) ) {
                    $this->propeties[$key] = $var;

                } else {
                    if ( $key === 'order-logs' && $key === 'anti-fraud' ) {
                        $this->propeties[$key] = false;
                    } else {
                        $this->status  = 400;
                        $this->response = [
                            'message' => __( "Invalid parameters! Some mandatory fields were not sent.", "wc-pagarme-payments" )
                        ];
                    }
                }
            }

            $this->get_payment_methods();
        }
    }

    /**
     * Set $message
     * @return string
     */
    public function get_response()
    {
        return $this->response;
    }

    /**
     * Get $status
     * @return int
     */
    public function get_status()
    {
        return $this->status;
    }
}