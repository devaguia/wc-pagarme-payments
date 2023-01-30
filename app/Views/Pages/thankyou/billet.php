<div class="woocommerce-order-details wpp-thakyou-page wpp-thakyou-page-billet">
    <h2 class="woocommerce-order-details__title"><?php echo __( "Pagar.me Payments", "wc-pagarme-payments" ); ?></h2>
    <div class="shop_table order_details">
        <div class="billet-url">
            <span><?php echo __( "Access your ticket here:", "wc-pagarme-payments" ); ?></span>
            <div>
                <a target="_blank" href="<?php echo esc_url( isset( $billet_url ) ? $billet_url : "" )?>"><?php echo __( "Access Billet", "wc-pagarme-payments" ); ?></a>
            </div>
        </div>
        <hr>
        <div class="billet-content">
            <div class="billet-barcode">
                <span><?php echo __( "Bar code:", "wc-pagarme-payments" ); ?></span>
                <img src="<?php echo esc_url( isset( $barcode ) ? $barcode : "" )?>" alt="Bar code" >
            </div>
            <div class="billet-line">
                <span><?php echo __( "Digitable line:", "wc-pagarme-payments" ); ?></span>
                <div>
                    <input type="text" name="" id="" value="<?php echo esc_attr( isset( $billet_line ) ? $billet_line : "" ); ?>" >
                    <span>
                        <i class="fa-regular fa-copy"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>