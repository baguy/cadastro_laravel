<?php

class TipoInformacao extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_informacao';

    public function informacao(){
      return $this->hasOne('Informacao', 'tipo_informacao_id', 'id');
    }

		public function setTipoInformacaoAttribute($tipo_informacao){
			$this->attributes['tipo_informacao'] = DB::table('tipo_informacao')->select('id')->where('nome', '=', $tipo_informacao)->first()->id;
	   }

  }
