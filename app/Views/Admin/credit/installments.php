<div class="wpp-installments-settings">
    <div class="close">
        <i class="fa-regular fa-circle-xmark"></i>
    </div>
    <div class="title">
        <div>
            <span><?php echo __( "Installment Settings","wc-pagarme-payments" );?></h2>
            <i class="fa-solid fa-gear"></i>
        </div>
        <span><?php echo __( "Fill in the fields below with the value(%) of interest you want to charge in each installment.", "wc-pagarme-payments" ); ?></span>
    </div>
    <form>
        <div class="installments-items">
            <?php for ($i=1; $i < 25; $i++) : ?>
                <div class="installments-item">
                    <div class="installment-fee">
                        <span><?php echo esc_html("{$i}°"); ?></span>
                        <input type="number" max="24" min="1">
                        <span><?php echo esc_html("(%)"); ?></span>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <div class="submit">
            <input type="submit" value="Salvar">
        </div>
    </form>
</div>