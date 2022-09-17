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
    public function __construct()
    {
        Application::bootWp();
    }
}
