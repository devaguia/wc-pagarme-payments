<?php

namespace WPP\Model;

use As247\WpEloquent\Application;

/**
 * Abstract class for repositories
 * @package Model
 * @since 1.0.0
 */
abstract class Repository 
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var object
     */
    protected $db;
    
    public function __construct()
    {
        $this->set_database();
    }

    /**
     * 
     */
    protected function set_database()
    {
        global $wpdb;

        if( $wpdb ) {
            $this->db = $wpdb;
            $this->set_prefix();
        }
    }

    /**
     * 
     */
    protected function set_prefix()
    {
        if ( $this->db ) {
            $this->prefix = $this->db->prefix;
        }
    }

    /**
     * 
     */
    protected function query( $query )
    {
        if ( strpos( $query, 'SELECT' ) === false ) {
            return $this->db->query( $query );
        }

        return $this->db->get_results( $query );
    }
}
