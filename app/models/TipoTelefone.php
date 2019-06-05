<?php

class TipoTelefone extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_telefone';

    public function telefones(){
      return $this->hasMany('Telefone', 'tipo_telefone_id', 'id');
    }

		public function setTipoTelefoneAttribute($tipo_telefone){
			$this->attributes['tipo_telefone'] = DB::table('tipo_telefone')->select('id')->where('nome', '=', $tipo_telefone)->first()->id;
	  }

  }
