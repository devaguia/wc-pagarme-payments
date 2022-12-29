<?php

namespace WPP\Model\Database\Tables;

use WPP\Model\Database\Table;

/**
 * Name: Order Logs
 * @package Model
 * @since 1.0.0
 */
class OrderLogs extends Table
{
    public function __construct()
    {
        $this->set_table( "wc_pagarme_logs" );
    }

    public function up() 
    {
        $this->create( [
            'id'         => [ 'INT AUTO_INCREMENT primary key NOT NULL' ],
            'post_id'    => [ 'INT NOT NULL' ],
            'key'        => [ 'varchar(255) NOT NULL' ],
            'value'      => [ 'TEXT' ],
            'created_at' => [ 'DATETIME DEFAULT CURRENT_TIMESTAMP' ],
            'updated_at' => [ 'DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP' ]
        ] );
    }

    public function down()
    {
        $this->drop();
    }
}


