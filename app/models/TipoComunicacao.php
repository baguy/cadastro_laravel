<?php

class TipoComunicacao extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_comunicacao';

    public function comunicacao(){
      return $this->hasMany('Comunicacao', 'tipo_comunicacao_id', 'id');
    }

		public function setTipoComunicacaoAttribute($tipo_comunicacao){
			$this->attributes['tipo_comunicacao'] = DB::table('tipo_comunicacao')->select('id')->where('nome', '=', $tipo_comunicacao)->first()->id;
	  }

  }
