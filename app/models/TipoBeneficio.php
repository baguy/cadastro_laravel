<?php

class TipoBeneficio extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_beneficio';

    public function beneficios(){
      return $this->hasMany('Beneficio', 'tipo_beneficio_id', 'id');
    }

		public function setTipoBeneficioAttribute($tipo_beneficio){
			$this->attributes['tipo_beneficio'] = DB::table('tipo_beneficio')->select('id')->where('nome', '=', $tipo_beneficio)->first()->id;
	  }

  }
