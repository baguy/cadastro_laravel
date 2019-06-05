<?php

class TipoTransporte extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_transporte';

    public function transporte(){
      return $this->hasOne('Transporte', 'tipo_transporte_id', 'id');
    }

		public function setTipoTransporteAttribute($tipo_transporte){
			$this->attributes['tipo_transporte'] = DB::table('tipo_transporte')->select('id')->where('nome', '=', $tipo_transporte)->first()->id;
	   }

  }
