<?php

class TipoTrabalho extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_trabalho';

    public function trabalho(){
      return $this->hasOne('Trabalho', 'tipo_trabalho_id', 'id');
    }

		public function setTipoTrabalhoAttribute($tipo_trabalho){
			$this->attributes['tipo_trabalho'] = DB::table('tipo_trabalho')->select('id')->where('nome', '=', $tipo_trabalho)->first()->id;
	   }

  }
