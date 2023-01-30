<?php

namespace WPP\Controllers\Entities;

use WPP\Model\Entity\Settings as Model;

/**
 * Name: Settings
 * @package Controller 
 * @since 1.0.0
 */
class Settings
{

    private array $propeties;
    private int $status;
    private array $response;

    public function __construct()
    {
        $this->sanitize_vars();
    }


    public function save(): void
    {
        $model = new Model();
        
        $model->set_secret_key( $this->propeties['secret-key'] );
        $model->set_public_key( $this->propeties['public-key'] );
        $model->set_payment_mode( $this->propeties['payment-mode'] );
        $model->set_success_status( $this->propeties['finish-order-status'] );

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


    private function sanitize_vars(): void
    {
        $vars = isset( $_POST['action'] ) && $_POST['action'] === 'save_pagarme_settings' ? $_POST : [];
        
        if ( ! empty( $vars ) ) {
            $needed = [ 
                'finish-order-status',
                'secret-key',
                'public-key',
                'payment-mode'
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
        }
    }


    public function get_response(): array
    {
        return $this->response;
    }


    public function get_status(): int
    {
        return $this->status;
    }
}