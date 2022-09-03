<?php use WPP\Helpers\Config; ?>
<div class="wpp-payment-container wpp-pix-checkout">
    <div>
        <div class="payment-message">
            <span><?php echo __( "Pay using QR Code", "wc-pagarme-payments" ); ?></span>
        </div>
        <div class="qrcode-image">
            <img src="<?php echo Config::__images( "qrcode.png" )?>" alt="Qr code icon">
        </div>
    </div>
    <div>
        <div class="payment-message">
            <span><?php echo __( "Or use copy and paste Pix", "wc-pagarme-payments" ); ?> <i class="fa-solid fa-paste"></i></span>
        </div>
    </div>
</div>