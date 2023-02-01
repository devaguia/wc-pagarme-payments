<div class="wrap wpp-wrap">
    <div class="wpp-container wpp-container-pagarme">
        <div class="title">
            <h1>
                <?php echo __( "Pagar.me General Settings", "wc-pagarme-payments" );?>
            </h1>
            <svg width="57" height="57" viewBox="0 0 57 57" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M42.8925 43.9518H56.9567C56.9783 43.3835 56.9999 42.8081 56.9999 42.2326C56.9711 18.9361 37.9328 0.0500387 14.4216 0V13.9215C30.1847 13.9465 42.9503 26.6134 42.9466 42.2326C42.9503 42.8045 42.9286 43.3799 42.8925 43.9518Z" fill="#65A300"></path><path d="M0 42.235C0 50.3896 6.76427 57.0001 15.1084 57.0001C23.4526 57.0001 30.2169 50.3896 30.2169 42.235C30.2169 34.0805 23.4526 27.47 15.1084 27.47C6.76427 27.47 0 34.0805 0 42.235Z" fill="#65A300"></path></svg>
            <?php if ( isset( $payment_mode_label ) && $payment_mode_label ): ?>
                <div class="wpp-payment-mode">
                    <span><?php echo esc_html( $payment_mode_label ); ?></span>
                </div>
            <?php endif; ?>
        </div>
        <hr>
        <form class="body" id="wpp-pagarme-settings">
            <div class="methods-section">
                <div>
                    <h3><? echo __( "Allowed Methods:", "wc-pagarme-payments" ); ?></h3>
                </div>
                <?php if ( isset( $methods ) && is_array( $methods ) ) :?>
                    <div class="methods">
                        <?php foreach( $methods as $key => $method ): ?>
                            <div class="method">
                                <div class="icon">

                                    <?php $activate = isset( $method['active'] ) && $method['active'] ? true : false; ?>

                                    <div class="status status-<?php echo esc_attr( $activate ? 'activate' : 'disabled' ); ?>">
                                        <i class="fa-solid fa-circle-<?php echo esc_attr( $activate ? 'check' : 'xmark' ); ?>"></i>
                                    </div>

                                </div>
                                <div class="label">
                                    <span>
                                        <?php echo esc_html( isset( $method['label'] ) ? $method['label'] : '' ); ?>
                                    </span>
                                </div>
                                <div>
                                    <span> | </span>
                                </div>
                                <div class="link">
                                    <a target="_blank" href="admin.php?page=wc-settings&tab=checkout&section=<?php echo esc_html( $key ) ?>">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach ?>
                <?php endif; ?>
            </div>
            <div class="plugin-options">
                <div class="title">
                    <h3><? echo __( "Plugin Options:", "wc-pagarme-payments" ); ?></h3>
                </div>
                <div class="status">
                    <h4>
                        <strong>
                            <?php echo __( "Status", "wc-pagarme-payments" ); ?>
                        </strong>
                    </h4>
                    <div>
                        <label for="">
                            <?php echo __( "Status for completed orders:", "wc-pagarme-payments" ); ?>
                        </label>
                        <select name="wpp-finish-order-status" id="wpp-finish-order-status" value="<?php echo esc_html( isset( $success_status ) ? $success_status : 'wc-processing' ); ?>" >

                            <?php if ( isset( $statuses ) ): ?>
                                <?php foreach ( $statuses  as $key => $status ): ?>
                                    <option value="<?php echo esc_attr( $key ); ?>" <?php echo $key === $success_status ? esc_html( 'selected' ) : '' ?>><?php echo esc_html( $status ) ?></option>
                                <?php endforeach; ?>
                            <?php endif;?>

                        </select>
                    </div>
                </div>
                <div class="status">
                    <h4><strong><?php echo __( "Export settings", "wc-pagarme-payments" ); ?></strong></h4>
                    <div class="export-settings">
                        <label><?php echo __( "Export settings and other useful information(for support).", "wc-pagarme-payments"); ?></label>
                        <div>
                            <button type="button" id="wpp-export-settings"><?php echo __( "Download", "wc-pagarme-payments"); ?><i class="fa-solid fa-download"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="payment-options">
                <div class="title">
                    <h3><? echo __( "Payment Options:", "wc-pagarme-payments" ); ?></h3>
                </div>
                <div class="keys">
                    <div>
                        <div class="key">
                            <div>
                                <span>
                                    <?php echo __( "Secret key:", "wc-pagarme-payments" ); ?>
                                </span>
                            </div>
                            <div>
                                <input type="password" name="wpp-secret-key" id="wpp-secret-key" value="<?php echo esc_html( isset( $secret_key ) ? $secret_key : '' ); ?>" placeholder="<?php echo __( "Leave blank if you don't want to use it.", "wc-pagarme-payments" ); ?>">
                            </div>
                        </div>
                        <div class="key">
                            <div>
                                <span>
                                    <?php echo __( "Public key:", "wc-pagarme-payments"  ); ?>
                                </span>
                            </div>
                            <div>
                                <input type="text" name="wpp-public-key" id="wpp-public-key" value="<?php echo esc_html( isset( $public_key ) ? $public_key : '' ); ?>" placeholder="<?php echo __( "Leave blank if you don't want to use it.", "wc-pagarme-payments" ); ?>">
                            </div>
                        </div>
                        <input type="hidden" name="wpp-payment-mode" id="wpp-payment-mode" value="<?php echo esc_html( isset( $payment_mode ) ? $payment_mode : '' ); ?>">
                    </div>
                </div>
                <div class="wpp-warnings">
                    <div class="wpp-warning" id="wpp-warning-equal-key">
                        <span>
                            <strong><?php echo __( "Warning: ", "wc-pagarme-payments" ); ?></strong>
                            <?php echo __( "Your keys must be of the same type (test or production).", "wc-pagarme-payments" ); ?>
                        </span>
                    </div>
                    <div class="wpp-warning" id="wpp-warning-valid-key">
                        <span>
                            <strong><?php echo __( "Warning: ", "wc-pagarme-payments" ); ?></strong>
                            <?php echo __( "One of your keys does not have the correct format!", "wc-pagarme-payments" ); ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="submit">
                <div>
                    <input type="submit" id="wpp-submit" value="<?php echo __( "Save Settings", "wc-pagarme-payments" ); ?>" >
                </div>
            </div>
        </form>
    </div>
</div>
