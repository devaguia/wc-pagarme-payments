<div class="wrap wpp-wrap">
    <div class="wpp-container wpp-container-pagarme">
        <div class="title">
            <h1><?php echo __( "Pagar.me General Settings" ); ?></h1>
            <svg width="57" height="57" viewBox="0 0 57 57" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M42.8925 43.9518H56.9567C56.9783 43.3835 56.9999 42.8081 56.9999 42.2326C56.9711 18.9361 37.9328 0.0500387 14.4216 0V13.9215C30.1847 13.9465 42.9503 26.6134 42.9466 42.2326C42.9503 42.8045 42.9286 43.3799 42.8925 43.9518Z" fill="#65A300"></path><path d="M0 42.235C0 50.3896 6.76427 57.0001 15.1084 57.0001C23.4526 57.0001 30.2169 50.3896 30.2169 42.235C30.2169 34.0805 23.4526 27.47 15.1084 27.47C6.76427 27.47 0 34.0805 0 42.235Z" fill="#65A300"></path></svg>
        </div>
        <hr>
        <form action="" class="body">
            <div class="methods-section">
                <div>
                    <h3><? echo __( "Allowed Methods:", "wc-pagarme-payments" ); ?></h3>
                </div>
                <div class="methods">
                    <div>
                        <div class="method">
                            <div class="status status-disabled">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div>
                            <div class="label">
                                <span> <?php echo __( "Bank Slip", "wc-pagarme-payments" ); ?></span>
                            </div>
                        </div>
                        <div class="method">
                            <div class="status status-disabled">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div>
                            <div class="label">
                                <span> <?php echo __( "Credit Card", "wc-pagarme-payments" ); ?></span>
                            </div>
                        </div>
                        <div class="method">
                            <div class="status status-activate">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div class="label">
                                <span> <?php echo __( "Pix", "wc-pagarme-payments" ); ?></span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="method">
                            <div class="mode">
                                <span><?php echo __( "sanbox", "wc-pagarme-payments" ); ?></span>
                            </div>
                        </div>
                        <div class="method">
                            <div class="mode">
                                <span><?php echo __( "sanbox", "wc-pagarme-payments" ); ?></span>
                            </div>
                        </div>
                        <div class="method">
                            <div class="mode">
                                <span><?php echo __( "production", "wc-pagarme-payments" ); ?></span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="method">
                            <div class="link">
                                <a target="_blank" href="admin.php?page=wc-settings&tab=checkout&section=wc-pagarme-billet">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>
                        </div>
                        <div class="method">
                            <div class="link">
                                <a target="_blank" href="admin.php?page=wc-settings&tab=checkout&section=wc-pagarme-credit">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>
                        </div>
                        <div class="method">
                            <div class="link">
                                <a target="_blank" href="admin.php?page=wc-settings&tab=checkout&section=wc-pagarme-pix">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="plugin-options">
                <div class="title">
                    <h3><? echo __( "Plugin Options:", "wc-pagarme-payments" ); ?></h3>
                </div>
                <div>
                    <div>
                        <input type="checkbox" name="show-icons" id="wpp-show-icons">
                        <label for="wpp-show-icons"><?php echo __( "Show Pagar.me icons on checkout.", "wc-pagarme-payments"); ?></label>
                    </div>
                </div>
            </div>
            <div class="payment-options">
                <div class="title">
                    <h3><? echo __( "Payment Options:", "wc-pagarme-payments" ); ?></h3>
                </div>
                <div class="secret-keys">
                    <div class="key">
                        <div>
                            <span><?php echo __( "Production secret key:", "wc-pagarme-payments" ); ?></span>
                        </div>
                        <div>
                            <input type="password" name="production-secret-key" id="production-secret-key">
                        </div>
                    </div>
                    <div class="key">
                        <div>
                            <span><?php echo __( "Test secret key:", "wc-pagarme-payments"  ); ?></span>
                        </div>
                        <div>
                            <input type="password" name="test-secret-key" id="test-secret-key">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="option">
                        <input type="checkbox" name="anti-fraud" id="wpp-anti-fraud">
                        <label for="wpp-anti-fraud"><?php echo __( "Enable anti-fraud.", "wc-pagarme-payments"); ?></label>
                        <div class="anti-fraud">
                            <label for=""><?php echo __( "Minimum value:", "wc-pagarme-payments"); ?></label>
                            <input type="text" name="anti-fraud-value" id="wpp-anti-fraud-value">
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
