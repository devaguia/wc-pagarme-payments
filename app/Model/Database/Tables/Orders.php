<?php

namespace WPP\Model\Database\Tables;

use As247\WpEloquent\Support\Facades\Schema;

/**
 * Name: Orders
 * @package Model
 * @since 1.0.0
 */
class Orders
{
    public function up() 
    {
        if ( ! Schema::hasTable( 'wc_pagarme_orders' ) ) {
            Schema::create( 'wc_pagarme_orders', function ( $table ) {
                $table->increments( 'id' );
                $table->string( 'pagarme_id' );
                $table->string( 'code' );
                $table->string( 'status' );
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::drop( 'wc_pagarme_orders' );
    }
}


