<?php

class TipoVidaDiaria extends Eloquent {

  	protected $table    = 'tipo_vida_diaria';

    public function vidaDiaria(){
        return $this->hasMany('VidaDiaria', 'tipo_vida_diaria_id', 'id');
    }

    public function setTipoCredencialAttribute($tipo_vida_diaria){
      $this->attributes['tipo_vida_diaria'] = DB::table('tipo_vida_diaria')->select('id')->where('nome', '=', $tipo_vida_diaria)->first()->id;
    }

}
