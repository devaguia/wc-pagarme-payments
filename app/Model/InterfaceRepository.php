<?php

namespace WPP\Model;

/**
 * Interface for repositories
 * @package Model
 * @since 1.0.0
 */
interface InterfaceRepository
{
    public function find( $key );
    public function save( $fields );
    public function update( $key, $value );
    public function insert( $key, $value );
}