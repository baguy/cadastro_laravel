<?php

class TipoSaude extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_saude';

    public function saudes(){
      return $this->hasMany('Saude', 'tipo_saude_id', 'id');
    }

		public function setTipoSaudeAttribute($tipo_saude){
			$this->attributes['tipo_saude'] = DB::table('tipo_saude')->select('id')->where('nome', '=', $tipo_saude)->first()->id;
	  }

  }
