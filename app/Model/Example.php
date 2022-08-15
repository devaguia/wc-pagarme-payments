<?php

namespace WCPT\Model\User;

use As247\WpEloquent\Database\Eloquent\Model;

/**
 * Name: User
 * @package Model/User 
 * @since 1.0.0
 */
class Example extends Model
{
   /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = [
       'description'
   ];
   
   /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
   protected $hidden = [];
 }