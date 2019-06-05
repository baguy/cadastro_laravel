<?php

class Escolaridade extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'escolaridade';
    protected $fillable = ['tipo_escolaridade_id', 'status', 'alfabetizado', 'instituicao', 'individuo_id', 'transporte_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

		public function tipoEscolaridade(){
			return $this->belongsTo('TipoEscolaridade', 'tipo_escolaridade_id', 'id');
		}

    public function transporte(){
      return $this->belongsTo('TipoTransporte', 'tipo_transporte_id', 'id');
    }

}
