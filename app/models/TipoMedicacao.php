<?php

class TipoMedicacao extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_medicacao';

    public function medicacao(){
      return $this->hasMany('Medicacao', 'tipo_medicacao_id', 'id');
    }

		public function setTipoMedicacaoAttribute($tipo_medicacao){
			$this->attributes['tipo_medicacao'] = DB::table('tipo_medicacao')->select('id')->where('nome', '=', $tipo_medicacao)->first()->id;
	  }

  }
