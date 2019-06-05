<?php

class TipoAtividade extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_atividade';

    public function esporte(){
      return $this->hasOne('Esporte', 'tipo_atividade_id', 'id');
    }

    public function cultural(){
      return $this->hasOne('Cultural', 'tipo_atividade_id', 'id');
    }

		public function setTipoAtividade($tipo_atividade){
			$this->attributes['tipo_atividade'] = DB::table('tipo_atividade')->select('id')->where('nome', '=', $tipo_atividade)->first()->id;
	   }

  }
