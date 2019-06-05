<?php

class Esporte extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'atividade_esporte';
    protected $fillable = ['obs', 'tipo_atividade_id', 'individuo_id', 'tipo_transporte_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

		public function tipoAtividade(){
			return $this->belongsTo('TipoAtividade', 'tipo_atividade_id', 'id');
		}

    public function transporte(){
      return $this->belongsTo('TipoTransporte', 'tipo_transporte_id', 'id');
    }

}
