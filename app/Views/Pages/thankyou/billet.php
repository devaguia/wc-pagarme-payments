<div class="woocommerce-order-details wpp-thakyou-page">
    <h2 class="woocommerce-order-details__title"><?php echo __( "Pagar.me Pyaments", "wc-pagarme-payments" ); ?></h2>
    <div class="shop_table order_details">
        <div class="billet-url">
            <span>Acesse aqui o seu boleto:</span>
            <div>
                <a href="<?php echo esc_url( isset( $billet_url ) ? $billet_url : "" )?>">Baixar Boleto</a>
            </div>
        </div>
        <div class="billet-barcode">
            <span>Código de Barras:</span>
            <img src="<?php echo esc_url( isset( $barcode ) ? $barcode : "" )?>" alt="Bar code" >
        </div>
        <div class="billet-line">
            <span>Linha digitável:</span>
            <div>
                <input type="text" name="" id="" value="<?php echo esc_attr( isset( $billet_line ) ? $billet_line : "" ); ?>" >
                <span>@</span>
            </div>
        </div>
    </div>
</div>