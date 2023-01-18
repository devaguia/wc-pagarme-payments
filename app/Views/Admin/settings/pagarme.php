<?php 
/**
 * Available variables
 * 
 * @var string $production_key 
 * @var string $test_key 
 * @var array $methods 
 * @var array $credit_installments 
 * @var array $anti_fraud 
 * @var string $anti_fraud_value 
 * @var string $success_status 
 * @var bool $order_logs 
 * @var int $api_version 
 */

?>

<div class="wrap wpp-wrap">
    <div class="wpp-container wpp-container-pagarme">
        <div class="title">
            <h1>
                <?php echo __( "Pagar.me General Settings" ); ?>
            </h1>
            <svg width="57" height="57" viewBox="0 0 57 57" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M42.8925 43.9518H56.9567C56.9783 43.3835 56.9999 42.8081 56.9999 42.2326C56.9711 18.9361 37.9328 0.0500387 14.4216 0V13.9215C30.1847 13.9465 42.9503 26.6134 42.9466 42.2326C42.9503 42.8045 42.9286 43.3799 42.8925 43.9518Z" fill="#65A300"></path><path d="M0 42.235C0 50.3896 6.76427 57.0001 15.1084 57.0001C23.4526 57.0001 30.2169 50.3896 30.2169 42.235C30.2169 34.0805 23.4526 27.47 15.1084 27.47C6.76427 27.47 0 34.0805 0 42.235Z" fill="#65A300"></path></svg>
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
                                <div class="mode">
                                    <span>
                                        <?php echo esc_html( isset( $method['mode'] ) ? $method['mode'] : '' ); ?>
                                    </span>
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
                    <h4><strong><?php echo __( "Order Logs", "wc-pagarme-payments" ); ?></strong></h4>
                    <div>
                        <input type="checkbox" name="wpp-order-logs" id="wpp-order-logs" <?php echo esc_attr( isset( $order_logs ) && $order_logs ? 'checked' : '' ) ?>>
                        <label for="wpp-order-logs"><?php echo __( "Add log section on order edit page.", "wc-pagarme-payments"); ?></label>
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
                                    <?php echo __( "Production secret key:", "wc-pagarme-payments" ); ?>
                                </span>
                            </div>
                            <div>
                                <input type="password" name="wpp-production-secret-key" id="wpp-production-secret-key" value="<?php echo esc_html( isset( $production_secret_key ) ? $production_secret_key : '' ); ?>" placeholder="<?php echo __( "Leave blank if you don't want to use it.", "wc-pagarme-payments" ); ?>">
                            </div>
                        </div>
                        <div class="key">
                            <div>
                                <span>
                                    <?php echo __( "Production public key:", "wc-pagarme-payments"  ); ?>
                                </span>
                            </div>
                            <div>
                                <input type="text" name="wpp-production-public-key" id="wpp-production-public-key" value="<?php echo esc_html( isset( $production_public_key ) ? $production_public_key : '' ); ?>" placeholder="<?php echo __( "Leave blank if you don't want to use it.", "wc-pagarme-payments" ); ?>">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="key">
                                <div>
                                    <span>
                                        <?php echo __( "Test secret key:", "wc-pagarme-payments" ); ?>
                                    </span>
                                </div>
                                <div>
                                    <input type="password" name="wpp-test-secret-key" id="wpp-test-secret-key" value="<?php echo esc_html( isset( $test_secret_key ) ? $test_secret_key : '' ); ?>" placeholder="<?php echo __( "Leave blank if you don't want to use it.", "wc-pagarme-payments" ); ?>">
                                </div>
                            </div>
                            <div class="key">
                                <div>
                                    <span>
                                        <?php echo __( "Test public key:", "wc-pagarme-payments"  ); ?>
                                    </span>
                                </div>
                                <div>
                                    <input type="text" name="wpp-test-public-key" id="wpp-test-public-key" value="<?php echo esc_html( isset( $test_public_key ) ? $test_public_key : '' ); ?>" placeholder="<?php echo __( "Leave blank if you don't want to use it.", "wc-pagarme-payments" ); ?>">
                                </div>
                            </div>
                        </div>
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
