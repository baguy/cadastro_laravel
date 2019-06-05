<?php

class QuandoDeficiencia extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'quando';

    public function deficiencias(){
      return $this->hasMany('Deficiencia', 'quando_id', 'id');
    }

  }
