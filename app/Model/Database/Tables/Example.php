<?php

namespace WPP\Model\Database\Tables;

use As247\WpEloquent\Support\Facades\Schema;

/**
 * Name: Example
 * @package Model/Database/Tables
 * @since 1.0.0
 */
class Example
{
    public function up() 
    {
        if ( ! Schema::hasTable( 'example' ) ) {
            Schema::create( 'example', function ( $table ) {
                $table->increments( 'id' );
                $table->string( 'description' );
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::drop( 'example' );
    }
}


