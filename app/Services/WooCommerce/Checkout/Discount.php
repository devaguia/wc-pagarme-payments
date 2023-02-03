<?php

namespace WPP\Services\WooCommerce\Checkout;

/**
 * Woocommerce discount controller
 * 
 * @package Services
 * @since 1.0.0
 */
class Discount
{
  public function __construct()
  {
    add_action( "woocommerce_cart_calculate_fees", [ $this, 'calculate_discount_totals' ], 10, 1 );
  }

  public function calculate_discount_totals( $cart )
  {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) || is_cart() ) return;

    if ( ! WC()->session->chosen_payment_method ) return;

    $namespace = $this->get_payment_method_namespace( WC()->session->chosen_payment_method );

    if ( $namespace && class_exists( $namespace ) ) {

        add_filter( 'woocommerce_coupons_enabled', '__return_true' );
    
        $gateway          = new $namespace;
        $enabled_discount = $gateway->get_option( "enabled_discount" );
    
        if ( $enabled_discount && $enabled_discount === 'yes' ) {
    
            $discount = intval( $gateway->get_option( "discount" ) );
    
            if ( $discount ) {
                $this->set_cart_discount( $discount, $cart );
                return;
            }
        }
    
    }

    $this->reset_cart_fee();

  }

  private function set_cart_discount( int $discount, object $cart ): void
  {
    $amount = floatval( $cart->get_cart_contents_total() ) / 100 * $discount;
    
    $amount = $amount > 0 ? -$amount : 0;
    $cart->add_fee( 
        __( "Payment discount", "wc-pagarme-payments" ), 
        $amount, 
        true
    );
  }

  private function reset_cart_fee(): void
  {
    $fees = WC()->cart->get_fees();

    if ( isset( $fees['payment-discount'] ) ) {
        unset( $fees['payment-discount'] );
    }

    WC()->cart->fees_api()->set_fees($fees);

  }

  private function get_payment_method_namespace( string $payment_id ): string
  {
    $namespace = "WPP\\Controllers\\Gateways\\";

    switch ($payment_id) {
        case 'wc-pagarme-billet':
            $namespace .= "Billet";
            break;

        case 'wc-pagarme-pix':
            $namespace .= "Pix";
            break;
        
        default:
            $namespace = "";
            break;
    }
    
    return $namespace;
  }
}