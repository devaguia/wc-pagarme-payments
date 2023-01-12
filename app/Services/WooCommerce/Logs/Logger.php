<?php

namespace WPP\Services\WooCommerce\Logs;

use WC_Logger;

/**
 * Name: Logs
 * Woocommerce logs
 * @package Services\WooCommerce
 * @since 1.0.0
 */
class Logger
{
  /**
   * @var WC_Logger
   */
  protected $wc;
  
  /**
   * @var string 
   */
  protected $prefix;

  public function __construct()
  {
    $this->wc = new WC_Logger();
    $this->prefix = WPP_PLUGIN_SLUG;
  }

  /**
   * Success log messages
   * @since 1.0.0
   * @param mixed $var
   * @return void
   */
  public function add( $var, $type = 'request' )
  {
    switch ( $type ) {
      case 'error':
        $log   = "{$this->prefix}-error";
        $title = '--- PAGAR.ME PAYMENTS ERROR LOG ---';
        break;

      case 'success':
        $log   = "{$this->prefix}-success";
        $title = '--- PAGAR.ME PAYMENTS SUCCESS LOG ---';
        break;

      case 'request':
        $log   = "{$this->prefix}-request";
        $title = '--- PAGAR.ME PAYMENTS REQUEST LOG ---';
      break;


      $this->wc->add( $log, "\n{$title} : \n" . print_r( $var, true ) . "\n" );
    }
  }
}