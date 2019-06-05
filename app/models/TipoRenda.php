<?php

class TipoRenda extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_renda';

    public function renda(){
      return $this->hasOne('Renda', 'tipo_renda_id', 'id');
    }

		public function setTipoRendaAttribute($tipo_renda){
			$this->attributes['tipo_renda'] = DB::table('tipo_renda')->select('id')->where('nome', '=', $tipo_renda)->first()->id;
	   }

  }
