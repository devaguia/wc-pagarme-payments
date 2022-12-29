<?php

use WPP\Helpers\Config;

?>
<div class="wpp-payment-cotainer wpp-credit-checkout">
    <div class="form-row form-row-wide line wpp-brands-section">
        <div class="label">
            <label><?php echo __( "Accepted card brands", "wc-pagarme-payments" ); ?></label>
        </div>
        <div class="brands">
            <img src="<?php echo esc_url( Config::__images( "icons/brands/mastercard.svg" ) ); ?>" alt="Mastercard">
            <img src="<?php echo esc_url( Config::__images( "icons/brands/visa.svg" ) ); ?>" alt="Visa">
            <img src="<?php echo esc_url( Config::__images( "icons/brands/elo.svg" ) ); ?>" alt="Elo">
            <img src="<?php echo esc_url( Config::__images( "icons/brands/hipercard.svg" ) ); ?>" alt="Hiper Card">
            <img src="<?php echo esc_url( Config::__images( "icons/brands/amex.svg" ) ); ?>" alt="American Express">
            <img src="<?php echo esc_url( Config::__images( "icons/brands/jcb.svg" ) ); ?>" alt="JCB">
            <img src="<?php echo esc_url( Config::__images( "icons/brands/discover.svg" ) ); ?>" alt="Discover">
            <img src="<?php echo esc_url( Config::__images( "icons/brands/diners.svg" ) ); ?>" alt="Diners">
            <img src="<?php echo esc_url( Config::__images( "icons/brands/aura.svg" ) ); ?>" alt="Aura">
        </div>
    </div>
    <div class="form-row form-row-wide line wpp-card-owner">
        <label><?php echo __( "Card Owner", "wc-pagarme-payments" ); ?> <span class="required">*</span></label>
        <input type="text" required autocomplete="off" name="wpp-card-owner" id="wpp-card-owner">
    </div>
    <div class="form-row form-row-wide line">
        <label><?php echo __( "Card Number", "wc-pagarme-payments" ); ?> <span class="required">*</span></label>
        <div class="wpp-card-img">
            <img id="wpp-credi-card-icon" src="<?php echo esc_url( Config::__images( "icons/brands/mono/generic.svg" ) ); ?>" data-img="mono/generic" alt="Credit card brand">
            <input type="text" required autocomplete="off" id="wpp-card-number" placeholder="0000 0000 0000 0000">
        </div>
    </div>
    <div class="line">
        <div class="form-row form-row-first ">
            <label><?php echo __( "Expiry Date", "wc-pagarme-payments" ); ?> <span class="required">*</span></label>
            <input type="text" required autocomplete="off" name="wpp-card-expiry" id="wpp-card-expiry" placeholder='<?php echo __( "MM/YY", "wc-pagarme-payments" ); ?>'>
        </div>
        <div class="form-row form-row-last">
            <label><?php echo __( "Card Code", "wc-pagarme-payments" ); ?> <span class="required">*</span></label>
            <div class="wpp-card-img">
                <img id="wpp-cvv-icon" src="<?php echo esc_url( Config::__images( "icons/brands/mono/cvv.svg" ) ); ?>" data-img="mono/cvv" alt="Credit card CVV">
                <input type="text" required placeholder="CVV" id="wpp-card-cvv" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="form-row form-row-wide line select">
        <label><?php echo __( "Installments", "wc-pagarme-payments" ); ?> <span class="required">*</span></label>
        <select name="wpp-card-installments" id="wpp-card-installments">
            <?php foreach ( $installments as $installment ) : ?>
                <option value="<?php echo esc_attr( $installment['installment'] ); ?>">
                    <?php echo esc_html( $installment['label'] ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="wpp-hiddens">
        <input type="hidden" name="wpp-card-brand" id="wpp-card-brand" value="">
        <input type="hidden" name="wpp-card-number" id="wpp-hidden-number" value="">
    </div>
</div>