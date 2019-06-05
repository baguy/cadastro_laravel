<?php

class Moradia extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'moradia';
    protected $fillable = ['outro', 'tipo_moradia_id', 'individuo_id', 'tipo_imovel_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

		public function tipoMoradia(){
			return $this->belongsTo('TipoMoradia', 'tipo_moradia_id', 'id');
		}

    public function tipoImovel(){
      return $this->belongsTo('TipoImovel', 'tipo_imovel_id', 'id');
    }

}
