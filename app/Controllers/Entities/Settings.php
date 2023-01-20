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
    public function save()
    {
        $model = new Model();
        
        $model->set_api_version( $this->propeties['pagarme-api-version'] );
        $model->set_secret_key( $this->propeties['secret-key'] );
        $model->set_public_key( $this->propeties['public-key'] );
        $model->set_success_status( $this->propeties['finish-order-status'] );
        $model->set_anti_fraud( $this->propeties['anti-fraud'] );
        $model->set_anti_fraud_value( $this->propeties['anti-fraud-value'] );
        $model->set_order_logs( $this->propeties['order-logs'] );

        $result = $model->save();

        if ( $result ) { 
            $this->status   = 200;
            $this->response = [
                'code'    => 200,
                'title'   => __( "Success!", "wc-pagarme-settings" ),
                'message' => __( "Settings saved successfully!", "wc-pagarme-settings" )
            ];

        } else {
            $this->status   = 400;
            $this->response = [
                'code'    => 400,
                'title'   => __( "Error!", "wc-pagarme-settings" ),
                'message' => __( "Could not save the settings!", "wc-pagarme-settings" )
            ];
        }
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
                'finish-order-status',
                'secret-key',
                'public-key',
                'anti-fraud-value',
                'pagarme-api-version',
                'order-logs',
                'anti-fraud'
            ];

            foreach ( $vars as $key => $var ) {
                $key = str_replace( "wpp-", "", $key );

                if( in_array( $key, $needed ) ) {
                    $this->propeties[$key] = $var;

                } else {
                    $this->status  = 400;
                    $this->response = [
                        'code'    => 400,
                        'title'   => __( "Error!", "wc-pagarme-settings" ),
                        'message' => __( "Invalid parameters! Some mandatory fields were not sent.", "wc-pagarme-payments" )
                    ];
                }
            }

            $double_check = [
                'wpp-order-logs',
                'wpp-anti-fraud'
            ];

            foreach ( $double_check as $var ) {
                if ( ! isset( $vars[$var] ) ) {
                    $var = str_replace( "wpp-", "", $var );
                    
                    $this->propeties[$var] = false;
                } 
            }
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