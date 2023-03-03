<?php

namespace WPP;

// Define names
define( 'WPP_PLUGIN_NAME', __( 'Pagarme payments for WooCommerce', 'wc-pagarme-payments' ) );
define( 'WPP_PLUGIN_SLUG', 'wc-pagarme-payments' );
define( 'WPP_PLUGIN_NAMESPACE', 'WPP' );
define( 'WPP_PLUGIN_PREFIX', 'wpp' );

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'add_action' ) ) exit;

require_once 'Core/Actions.php';