<?php

class TipoTecnologiaAssistiva extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_tecnologia_assistiva';

    public function tecnologiaAssistiva(){
      return $this->hasMany('TecnologiaAssistiva', 'tipo_tecnologia_assistiva_id', 'id');
    }

		public function setTipoTecnologiaAssistivaAttribute($tipo_tecnologia_assistiva){
			$this->attributes['tipo_tecnologia_assistiva'] = DB::table('tipo_tecnologia_assistiva')->select('id')->where('nome', '=', $tipo_tecnologia_assistiva)->first()->id;
	  }

  }
