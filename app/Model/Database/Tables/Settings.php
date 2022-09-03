<?php

namespace WPP\Model\Database\Tables;

use As247\WpEloquent\Support\Facades\Schema;
use As247\WpEloquent\Support\Facades\Hash;

/**
 * Name: Settings
 * @package Model/Database/Tables
 * @since 1.0.0
 */
class Settings
{
    public function up() 
    {
        if ( ! Schema::hasTable( 'wc_pagarme_settings' ) ) {
            Schema::create( 'wc_pagarme_settings', function ( $table ) {
                $table->increments( 'id' );
                $table->string( 'production_key' );
                $table->string( 'test_key' );
                $table->string( 'methods' );
                $table->string( 'credit_installments' );
                $table->boolean( 'anti_fraud' );
                $table->float( 'anti_fraud_value' );
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::drop( 'wc_pagarme_settings' );
    }
}


