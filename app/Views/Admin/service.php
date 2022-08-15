<div class="wrap wcpt-wrap">
    <?php

use WCPT\Helpers\Config;

 $header = require __DIR__ . '/template-parts/header.php'; ?>
    
    <div class="wcpt-container wcpt-container-about">
        <div>
            <div class="title">
                <h1><?php echo __( "Hello World!", 'wc-plugin-template' ); ?></h1>
                <img src="<?php echo esc_url( Config::__images( 'cb-icon.png' ) ) ?>" alt="Code Backery Icon">
                <hr>
            </div>
            <div class="content">
                <div>
                    <p><?php echo __( "This is a WooCommerce payment plugin setup. You can use to initiate a WordPress plugin!", 'wc-plugin-template' ); ?></p>
                    <p><?php echo __( "Usually this page is for adding settings related to the integrated payment service, but feel free to do whatever you want.", 'wc-plugin-template' ); ?></p>
                </div>
                <div>
                    <p><?php echo __( "What changes the environment is the point of view. Use wisely!", 'wc-plugin-template' ); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
