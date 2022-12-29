<div class="wpp-payment-cotainer wpp-credit-checkout">
    <div class="form-row form-row-wide line">
        <label><?php echo __( "Card Owner", "wc-pagarme-payments" ); ?> <span class="required">*</span></label>
        <input type="text" required autocomplete="off" name="wpp-card-owner" id="wpp-card-owner">
    </div>
    <div class="form-row form-row-wide line">
            <label><?php echo __( "Card Number", "wc-pagarme-payments" ); ?> <span class="required">*</span></label>
        <input type="text" required autocomplete="off" name="wpp-card-number" id="wpp-card-number" placeholder="0000 0000 0000 0000">
    </div>
    <div class="line">
        <div class="form-row form-row-first ">
            <label><?php echo __( "Expiry Date", "wc-pagarme-payments" ); ?> <span class="required">*</span></label>
            <input type="text" required autocomplete="off" name="wpp-card-expiry" id="wpp-card-expiry" placeholder='<?php echo __( "MM/YY", "wc-pagarme-payments" ); ?>'>
        </div>
        <div class="form-row form-row-last">
            <label><?php echo __( "Card Code", "wc-pagarme-payments" ); ?> <span class="required">*</span></label>
            <input type="text" required placeholder="CVV" name="wpp-card-cvv" id="wpp-card-cvv" autocomplete="off">
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
</div>