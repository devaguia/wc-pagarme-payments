<?php if ( $logs ) : ?>
    <div class="wpp-logs-metabox">
        <div>
            <textarea id="wpp-order-logs" readonly ></textarea>
        </div>
        <div class="actions">
            <input type="button" class="button button-primary" value="<?php echo esc_attr( __( "Download", "wc-pagarme-payments" ) ); ?>">
        </div>
    </div>
<?php else: ?>
    <div>
        <span><?php echo esc_html( __( "No records found.", "wc-pagarme-payments" ) ); ?></span>
    </div>
<?php endif; ?>

