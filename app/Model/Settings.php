<?php

namespace WPP\Model;

use As247\WpEloquent\Database\Eloquent\Model;

/**
 * Name: Settings
 * @package Model 
 * @since 1.0.0
 */
class Settings extends Model
{
   /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = [
       'description',
       'production_key',
       'test_key',
       'methods',
       'credit_installments',
       'anti_fraud',
       'anti_fraud_value'
   ];
   
   /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
   protected $hidden = [];
 }