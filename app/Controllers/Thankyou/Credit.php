<?php

namespace WPP\Controllers\Thankyou;

use WPP\Controllers\Render\Render;

/**
 * Render Credit thankyou page
 * @package Controller\Render
 * @since 1.0.0
 */
class Credit extends Render
{
    private int $wc_order_id;

    public function __construct( $wc_order_id )
    {
        $this->wc_order_id = $wc_order_id;
        $this->request();
    }

    private function get_metas(): array
    {
        $keys  = [ 'card_first_digits', 'card_last_digits', 'card_brand', 'card_holder_name', 'card_exp_month', 'card_exp_year', 'status' ];
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
        $this->enqueue_styles( [ 'name' => 'wpp-credit-thankyou', 'file' => 'styles/theme/pages/thankyou/credit.css' ] );
    }
    
    public function request(): void
    {
        $metas = $this->get_metas();

        $this->render( 'Pages/thankyou/credit.php', $metas );
        $this->enqueue();
    }
}