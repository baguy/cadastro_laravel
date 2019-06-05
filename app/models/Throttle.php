<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Throttle extends Eloquent {

	protected $table    = 'throttles';

	protected $hidden   = array();

  protected $fillable = array('ip_address', 'last_access_at', 'attempts', 'last_attempt_at', 'suspended', 'user_id');

  protected $guarded  = array();

  public $timestamps  = false;

  public function user() {
    return $this->belongsTo('User');
  }
}