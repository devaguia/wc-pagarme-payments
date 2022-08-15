<?php

namespace WCPT;

// Define names
define( 'WCPT_PLUGIN_NAME', 'Payment setup plugin for Woocommerce' );
define( 'WCPT_PLUGIN_SLUG', 'wc-plugin-template' );
define( 'WCPT_PLUGIN_NAMESPACE', 'WCPT' );
define( 'WCPT_PLUGIN_PREFIX', 'wcpt' );

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'add_action' ) ) exit;

require_once 'Core/Actions.php';