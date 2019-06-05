<?php

class TipoInformacaoOrigem extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_informacao_origem';

    public function informacao(){
      return $this->hasOne('Informacao', 'tipo_informacao_id', 'id');
    }

		public function setTipoInformacaoAttribute($tipo_informacao_origem){
			$this->attributes['tipo_informacao_origem'] = DB::table('tipo_informacao_origem')->select('id')->where('nome', '=', $tipo_informacao_origem)->first()->id;
	   }

  }
