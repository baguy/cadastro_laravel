<?php

class TipoMoradia extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_moradia';

    public function moradia(){
      return $this->hasOne('Moradia', 'tipo_moradia_id', 'id');
    }

		public function setTipoMoradia($tipo_moradia){
			$this->attributes['tipo_moradia'] = DB::table('tipo_moradia')->select('id')->where('nome', '=', $tipo_moradia)->first()->id;
	   }

  }
