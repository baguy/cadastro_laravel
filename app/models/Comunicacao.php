<?php

class Comunicacao extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'comunicacao';
    protected $fillable = ['tipo_comunicacao_id', 'outro', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoComunicacao(){
      return $this->belongsTo('TipoComunicacao', 'tipo_comunicacao_id', 'id');
    }

}
