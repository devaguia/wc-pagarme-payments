<?php

namespace WPP\Model\Database\Tables;

use As247\WpEloquent\Support\Facades\Schema;

/**
 * Name: Settings
 * @package Model
 * @since 1.0.0
 */
class Settings
{
    public function up() 
    {
        if ( ! Schema::hasTable( 'wc_pagarme_settings' ) ) {
            Schema::create( 'wc_pagarme_settings', function ( $table ) {
                $table->increments( 'id' );
                $table->string( 'key' );
                $table->string( 'value' );
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::drop( 'wc_pagarme_settings' );
    }
}


