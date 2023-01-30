<div class="woocommerce-order-details wpp-thakyou-page wpp-thakyou-page-credit">
    <h2 class="woocommerce-order-details__title"><?php echo __( "Pagar.me Payments", "wc-pagarme-payments" ); ?></h2>
    <div class="shop_table order_details">
        <h3><?php echo __( "Pagar.me credit card information", "wc-pagarme-payments" ); ?></h3>
        <div class="credit-content">
            <div class="credit-holder-name">
                <span><?php echo __( "Card holder name:", "wc-pagarme-payments" ); ?></span>
                <div>
                    <span><?php echo esc_html( $card_holder_name ); ?></span>
                </div>
            </div>
            <div class="credit-card-number">
                <span><?php echo __( "Card number:", "wc-pagarme-payments" ); ?></span>
                <div>
                    <span><?php echo esc_html( $card_first_digits . "*****" . $card_last_digits ); ?></span>
                </div>
                <div>
                    <span><?php echo esc_html( strtoupper( $card_brand ) ); ?></span>
                </div>
            </div>
            <div class="credit-expiration">
                <span><?php echo __( "Card expiration:", "wc-pagarme-payments" ); ?></span>
                <div>
                    <span><?php echo esc_html( $card_exp_month . "/" . $card_exp_year ); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>