<?php

namespace WPP\Model\Database;

use WPP\Model\Database\Tables\Settings;

/**
 * Initialize database settings
 * @package Model
 * @since 1.0.0
 */
class Bootstrap
{
   public $tables;

   public function __construct()
   {
      $this->tables = [
         Settings::class
      ];

      $this->init();
   }


   public function init(): void
   {
      $this->tables();
   }


   public function uninstall(): void
   {
      foreach ($this->tables as $table) {
         if ( class_exists( $table ) ) {
            $t = new $table;
            $t->down();
         }
      }
   }

   private function tables() : void
   {
      foreach ($this->tables as $table) {
         if ( class_exists( $table ) ) {
            $t = new $table;
            $t->up();
         };
      }
   }
}

