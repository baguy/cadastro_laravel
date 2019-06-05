<?php

class Transporte extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'transporte';
    protected $fillable = ['tipo_transporte_id', 'outro', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoTransporte(){
      return $this->belongsTo('TipoTransporte', 'tipo_transporte_id', 'id');
    }

}
