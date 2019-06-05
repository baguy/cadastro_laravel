<?php

Class Logger extends Eloquent {

  protected $table    = 'loggers';

  protected $fillable = array('action', 'message', 'user_id', 'created_at');
  
  public $timestamps  = false;

  public function user() {
    return $this->belongsTo('User')->withTrashed();
  }

}