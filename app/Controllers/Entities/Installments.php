<?php

namespace WPP\Controllers\Entities;

use WPP\Helpers\Utils;
use WPP\Model\Entity\Settings as Model;

/**
 * Name: Settings
 * @package Controller 
 * @since 1.0.0
 */
class Installments
{
    /**
     * @var array
     */
    private $installments;

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
        $model  = new Model( true );
        $teste = serialize($this->installments);
        error_log( var_export($teste, true ) );
        error_log( var_export( unserialize($teste), true ) );

        $result = $model->save_single( 'credit_installments', serialize( $this->installments ) );

        if ( $result ) { 
            $this->status   = 200;
            $this->response = [
                'code'    => 200,
                'title'   => __( "Success!", "wc-pagarme-settings" ),
                'message' => __( "Installments saved successfully!", "wc-pagarme-settings" )
            ];

        } else {
            $this->status   = 400;
            $this->response = [
                'code'    => 400,
                'title'   => __( "Error!", "wc-pagarme-settings" ),
                'message' => __( "Could not save the installments settings!", "wc-pagarme-settings" )
            ];
        }
    }

    /**
     * Sanitize propeties vars
     * @return void
     */
    private function sanitize_vars()
    {
        $vars = isset( $_POST['action'] ) && $_POST['action'] === 'save_pagarme_installments' ? $_POST : [];
        if ( ! empty( $vars ) && isset( $vars['installments'] ) ) {
            $installments = json_decode( stripslashes($vars['installments']) );

            if ( $installments ) {
                $this->installments = $this->format_installments( $installments );
            }
        }
    }

    /**
     * 
     */
    private function format_installments( $installments )
    {
        $formated = [];
        if ( ! empty( $installments ) ) {
            foreach ( $installments as $installment ) {
                $formated[$installment->index] = $installment->value;
            }
        }

        return $formated;
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