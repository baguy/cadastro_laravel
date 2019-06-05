<?php

class Pais extends Eloquent {

		public $timestamps = false;
  	protected $table    = 'pais';
    protected $fillable = array('nome', 'sigla');

    public function estado(){
      return $this->hasMany('Estado', 'pais_id', 'id');
    }

}
