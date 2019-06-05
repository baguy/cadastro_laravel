<?php

class ConsequenciaQueda extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'consequencia_queda';

    public function quedas(){
      return $this->hasMany('Queda', 'consequencia_queda_id', 'id');
    }

		public function setTipoConsequenciaQuedaAttribute($consequencia_queda){
			$this->attributes['consequencia_queda'] = DB::table('consequencia_queda')->select('id')->where('nome', '=', $consequencia_queda)->first()->id;
	  }

  }
