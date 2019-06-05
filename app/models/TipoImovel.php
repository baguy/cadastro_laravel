<?php

class TipoImovel extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_imovel';

    public function moradia(){
      return $this->hasOne('Moradia', 'tipo_imovel_id', 'id');
    }

		public function setTipoImovel($tipo_imovel){
			$this->attributes['tipo_imovel'] = DB::table('tipo_imovel')->select('id')->where('nome', '=', $tipo_imovel)->first()->id;
	   }

  }
