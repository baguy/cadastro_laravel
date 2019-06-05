<?php

class TipoCredencial extends Eloquent {

  	protected $table = 'tipo_credencial';

    public function credencial(){
        return $this->hasOne('Credencial', 'tipo_credencial_id', 'id');
    }

    public function individuo(){
        return $this->belongsTo('Individuo');
    }

    public function setTipoCredencialAttribute($tipo_credencial){
      $this->attributes['tipo_credencial'] = DB::table('tipo_credencial')->select('id')->where('nome', '=', $tipo_credencial)->first()->id;
    }

}
