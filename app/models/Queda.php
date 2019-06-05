<?php

class Queda extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'queda';
    protected $fillable = ['consequencia_queda_id', 'local', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function consequenciaQueda(){
      return $this->belongsTo('ConsequenciaQueda', 'consequencia_queda_id', 'id');
    }

}
