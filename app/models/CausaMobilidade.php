<?php

class CausaMobilidade extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'causa_mobilidade';

    public function mobilidades(){
      return $this->hasMany('Mobilidade', 'causa_mobilidade_id', 'id');
    }

		public function setTipoMobilidadeAttribute($tipo_mobilidade){
			$this->attributes['tipo_mobilidade'] = DB::table('tipo_mobilidade')->select('id')->where('nome', '=', $tipo_mobilidade)->first()->id;
	  }

  }
