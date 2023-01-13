<?php

namespace WPP\Controllers\Thankyou;

use WPP\Controllers\Render\Render;

/**
 * Name: Render Billet thankyou page
 * @package Controller\Render
 * @since 1.0.0
 */
class Billet extends Render
{
    /**
     * @var int
     */
    private $wc_order_id;

    public function __construct( $wc_order_id )
    {
        $this->wc_order_id = $wc_order_id;
        $this->request();
    }

    /**
     * Get order payment meta values
     * @since 1.0.0
     * @return array
     */
    private function get_metas()
    {
        $keys  = [ 'barcode', 'billet_line', 'transaction_type', 'billet_url', 'billet_pdf', 'status' ];
        $metas = [];
        
        foreach ( $keys as $key ) {
            $value = get_post_meta( $this->wc_order_id, "wc-pagarme-$key", true );

            if ( $value ) {
                $metas[$key] = $value;
            }
        }
        
        return $metas;
    }

    /**
     * Enqueue custom scripts and styles to the page
     * @since 1.0.0
     * @return void
     */
    private function enqueue()
    {
        $this->enqueue_styles( [ 'name' => 'wpp-billet-thankyou', 'file' => 'styles/theme/pages/thankyou/billet.css' ] );
    }
    
    public function request()
    {
        $metas = $this->get_metas();

        $this->render( 'Pages/thankyou/billet.php', $metas );
        $this->enqueue();
    }
}