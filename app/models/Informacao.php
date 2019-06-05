<?php

class Informacao extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'informacao';
    protected $fillable = ['tipo_informacao_id', 'obs', 'tipo_informacao_origem_id', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

		public function tipoInformacao(){
			return $this->belongsTo('TipoInformacao', 'tipo_informacao_id', 'id');
		}

		public function tipoInformacaoOrigem(){
			return $this->belongsTo('TipoInformacaoOrigem', 'tipo_informacao_origem_id', 'id');
		}

}
