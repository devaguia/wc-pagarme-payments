<?php

namespace WPP\Model\Database;

use As247\WpEloquent\Application;
use WPP\Model\Database\Tables\Orders;
use WPP\Model\Database\Tables\Settings;

/**
 * Name: Bootstrap
 * @package Model/Database
 * @since 1.0.0
 */
class Bootstrap
{
   public $tables;

   public function __construct()
   {
      $this->tables = [
         Settings::class,
         Orders::class
      ];

      $this->init();
   }

   /**
    * Initialize configurations
    * @since 1.0.0
    * @return void
    */
   public function init()
   {
      Application::bootWp();
      $this->tables();
   }

   /**
    * Remove custom tables on database
    * @since 1.0.0
    * @return void
    */
   public function uninstall()
   {
      foreach ($this->tables as $table) {
         if ( class_exists( $table ) ) {
            $t = new $table;
            $t->down();
         }
      }
   }

   /**
    * Initialize custom tables on database
    * @since 1.0.0
    * @return void
    */
   private function tables() 
   {
      foreach ($this->tables as $table) {
         if ( class_exists( $table ) ) {
            $t = new $table;
            $t->up();
         };
      }
   }
}

