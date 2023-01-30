<?php

namespace WPP\Controllers\Thankyou;

use WPP\Controllers\Render\Render;

/**
 * Render Billet thankyou page
 * @package Controller\Render
 * @since 1.0.0
 */
class Billet extends Render
{
    private int $wc_order_id;

    public function __construct( $wc_order_id )
    {
        $this->wc_order_id = $wc_order_id;
        $this->request();
    }

    private function get_metas(): array
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

    private function enqueue(): void
    {
        $this->enqueue_styles( [ 'name' => 'wpp-billet-thankyou', 'file' => 'styles/theme/pages/thankyou/billet.css' ] );
        $this->enqueue_scripts( [ 'name' => 'wpp-billet-thankyou', 'file' => 'scripts/theme/pages/billet/thankyou.js' ] );
    }
    
    public function request(): void
    {
        $metas = $this->get_metas();

        $this->render( 'Pages/thankyou/billet.php', $metas );
        $this->enqueue();
    }
}