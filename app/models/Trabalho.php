<?php

class Trabalho extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'trabalho';
    protected $fillable = ['tipo_trabalho_id', 'profissao', 'local', 'periodo', 'individuo_id', 'transporte_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoTrabalho(){
      return $this->belongsTo('TipoTrabalho', 'tipo_trabalho_id', 'id');
    }

		public function transporte(){
			return $this->belongsTo('TipoTransporte', 'tipo_transporte_id', 'id');
		}

}
