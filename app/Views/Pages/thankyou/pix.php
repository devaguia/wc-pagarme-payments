<div class="woocommerce-order-details wpp-thakyou-page wpp-thakyou-page-pix">
    <h2 class="woocommerce-order-details__title"><?php echo __( "Pagar.me Payments", "wc-pagarme-payments" ); ?></h2>
    <div class="shop_table order_details">
        <div class="pix-url">
            <span><?php echo __( "Access QR code link here:", "wc-pagarme-payments" ); ?></span>
            <div>
                <a target="_blank" href="<?php echo esc_url( isset( $pix_qrcode ) ? $pix_qrcode : "" )?>"><?php echo __( "Access QR code", "wc-pagarme-payments" ); ?></a>
            </div>
        </div>
        <div class="pix-content">
            <span><?php echo __( "Scan the QR code below:", "wc-pagarme-payments" ); ?></span>
            <div>
                <img src="<?php echo esc_url( isset( $pix_url ) ? $pix_url : "" )?>" alt="Pix QR code">
            </div>
        </div>
    </div>
</div>