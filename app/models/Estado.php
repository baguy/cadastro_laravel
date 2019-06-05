<?php

class Estado extends Eloquent{

  	protected $table    = 'estado';
    protected $fillable = array('uf', 'nome');

    public function cidades(){
      return $this->hasMany('Cidade', 'estado_id', 'id');
    }

    public function pais(){
      return $this->belongsTo('Pais');
    }

    public function setEstadoAttribute($estado){
        $this->attributes['estado'] = DB::table('estado')->select('id')->where('nome', '=', $estado)->first()->id;
    }

}
