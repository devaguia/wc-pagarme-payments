<?php

namespace WPP\Controllers\Menus;

use WPP\Helpers\Utils;
use WPP\Model\Entity\Settings;

/**
 * Name: Settings
 * @package Controller 
 * @since 1.0.0
 */
class Installments
{
    /**
     * Get installments on database
     * @return array
     */
    private function get_installments()
    {
        $model = new Settings( true );
        $installments = $model->get_single( 'credit_installments' );
        
        if ( isset( $installments->value ) && is_serialized( $installments->value ) ) {
            return unserialize( $installments->value );
        }

        return [];
    }

    /**
     * Call the view render
     * @return void
     */
    public function request()
    {
        $installments = $this->get_installments();
        return Utils::render( 'Admin/credit/installments.php', [
            'installments' => $installments
        ] );
    }
}