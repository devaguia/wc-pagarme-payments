<?php

namespace WPP\Model\Entity;

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
    'id',
    'key',
    'value'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];
 }