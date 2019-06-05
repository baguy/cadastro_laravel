<?php

class TipoEstadoCivil extends Eloquent {

		public $timestamps = false;
  	protected $table    = 'tipo_estado_civil';

    public function estadoCivil(){
      return $this->hasMany('EstadoCivil', 'tipo_estado_civil_id', 'id');
    }

		public function setTipoEstadoCivilAttribute($tipo_estado_civil){
			$this->attributes['tipo_estado_civil'] = DB::table('tipo_estado_civil')->select('id')->where('tipo', '=', $tipo_telefone)->first()->id;
	}

}
