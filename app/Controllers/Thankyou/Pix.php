<?php

namespace WPP\Controllers\Thankyou;

use WPP\Controllers\Render\Render;

/**
 * Name: Render Pix thankyou page
 * @package Controller\Render
 * @since 1.0.0
 */
class Pix extends Render
{
    private int $wc_order_id;

    public function __construct( $wc_order_id )
    {
        $this->wc_order_id = $wc_order_id;
        $this->request();
    }

    private function get_metas(): array
    {
        $keys  = [ 'pix_qrcode', 'pix_url', 'pix_expiration', 'transaction_type', 'status' ];
        $metas = [];
        
        foreach ( $keys as $key ) {
            $value = get_post_meta( $this->wc_order_id, "wc-pagarme-$key", true );

            if ( $value ) {
                $metas[$key] = $value;
            }
        }
        
        return $metas;
    }

    private function enqueue(): void
    {
        $this->enqueue_styles( [ 'name' => 'wpp-pix-thankyou', 'file' => 'styles/theme/pages/thankyou/pix.css' ] );
    }
    
    public function request(): void
    {
        $metas = $this->get_metas();

        $this->render( 'Pages/thankyou/pix.php', $metas );
        $this->enqueue();
    }
}