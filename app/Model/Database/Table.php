<?php

namespace WPP\Model\Database;

/**
 * Abstract class for table model
 * @package Model
 * @since 1.0.0
 */
abstract class Table
{
    protected string $prefix;
    protected object $db;
    protected string $table;

    private function set_database(): void
    {
        global $wpdb;

        if( $wpdb ) {
            $this->db = $wpdb;
            $this->set_prefix();
        }
    }


    private function set_prefix(): void
    {
        if ( $this->db ) {
            $this->prefix = $this->db->prefix;
        }
    }


    protected function set_table( $table ): void
    {
        $this->set_database();
        $this->table = $this->prefix . $table;
    }


    protected function create( $fields = [] ): void
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


    protected function drop(): void
    {
        $this->db->query( "DROP TABLE {$this->table};" );
    }

}