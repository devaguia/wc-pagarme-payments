<?php

namespace WPP\Services\WooCommerce\Logs;

use WC_Logger;

/**
 * Woocommerce logs
 * @package Services
 * @since 1.0.0
 */
class Logger
{
  private WC_Logger $wc;
  private string $prefix;
  private bool $enabled;

  public function __construct( bool $enabled = true )
  {
    $this->wc      = new WC_Logger();
    $this->enabled = $enabled;
    $this->prefix  = WPP_PLUGIN_SLUG;
  }

  public function add( $var, string $type = 'request' ): void
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
    }

    if ( $this->enabled ) {
      $this->wc->add( $log, "\n{$title} : \n" . print_r( $var, true ) . "\n" );
    }
  }
}