<?php

namespace WCPT\Services\WooCommerce\Logs;

use WC_Logger;

/**
 * Name: Logs
 * Woocommerce logs
 * @package Services\WooCommerce
 * @since 1.0.0
 */
abstract class Logs
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
    $this->prefix = WCPT_PLUGIN_SLUG;
  }

  /**
   * Success log messages
   * @since 1.0.0
   * @param string $name 
   * @param string $title 
   * @param mixed $var
   * @return void
   */
  protected function success_log( $name, $title, $var )
  {
    $log = $this->prefix . "-$name-" . "success";
    $this->wc->add( $log, "{$title} : ".print_r( $var, true ) );
  }

  /**
   * Error log messages
   * @since 1.0.0
   * @param string $name 
   * @param string $title 
   * @param mixed $var
   * @return void
   */
  protected function error_log( $name, $title, $var )
  {
    $log = $this->prefix . "-$name-" . "error";
    $this->wc->add( $log, "{$title} : ".print_r( $var, true ) );
  }
}