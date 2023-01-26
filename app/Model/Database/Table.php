<?php

namespace WPP\Model\Database;

abstract class Table
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var object
     */
    protected $db;

    /**
     * @var string
     */
    protected $table;

    /**
     * Set WPDB object
     * @return void
     */
    private function set_database()
    {
        global $wpdb;

        if( $wpdb ) {
            $this->db = $wpdb;
            $this->set_prefix();
        }
    }

    /**
     * Set table prefix property
     * @return void
     */
    private function set_prefix()
    {
        if ( $this->db ) {
            $this->prefix = $this->db->prefix;
        }
    }

    /**
     * Set table property
     * @return void
     */
    protected function set_table( $table )
    {
        $this->set_database();
        $this->table = $this->prefix . $table;
    }

    protected function create( $fields = [] )
    {
        if ( empty( $fields ) ) return;

        $rows = [];
        
        foreach( $fields as $key => $value ) {
            $row = "`$key` " . implode( " ", $value );
            array_push( $rows, $row );
        }

        $fields = implode( ",", $rows );
        $this->db->query( "CREATE TABLE IF NOT EXISTS {$this->table} ( {$fields} );"  );
    }

    protected function drop()
    {
        $this->db->query( "DROP DATABASE {$this->table};" );
    }

}