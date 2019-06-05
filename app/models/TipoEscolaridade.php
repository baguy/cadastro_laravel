<?php

class TipoEscolaridade extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_escolaridade';

    public function escolaridade(){
      return $this->hasOne('Escolaridade', 'tipo_escolaridade_id', 'id');
    }

		public function setTipoEscolaridadeAttribute($tipo_escolaridade){
			$this->attributes['tipo_escolaridade'] = DB::table('tipo_escolaridade')->select('id')->where('nome', '=', $tipo_escolaridade)->first()->id;
	   }

  }
