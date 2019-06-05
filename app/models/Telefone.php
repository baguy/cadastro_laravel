<?php

class Telefone extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'telefone';
    protected $fillable = array('numero', 'ramal', 'individuo_id', 'tipo_telefone_id');

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoTelefone(){
      return $this->belongsTo('TipoTelefone', 'id', 'tipo_telefone_id');
    }

		// public function setNumeroAttribute($numero){
		// 	$this->attributes['numero'] = FormatterHelper::somenteNumeros($numero);
		// }

}
