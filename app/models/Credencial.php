<?php

class Credencial extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'credencial';
    protected $fillable = ['credencial', 'tipo_credencial_id', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoCredencial(){
      return $this->belongsTo('TipoCredencial', 'tipo_credencial_id', 'id');
    }

}
