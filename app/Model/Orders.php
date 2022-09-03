<?php

namespace WPP\Model;

use As247\WpEloquent\Database\Eloquent\Model;

/**
 * Name: Settings
 * @package Model 
 * @since 1.0.0
 */
class Orders extends Model
{
   /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = [
       'pagarme_id',
       'code',
       'status'
   ];
   
   /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
   protected $hidden = [];
 }