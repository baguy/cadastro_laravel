<?php

class Parentesco extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'parentesco';
    protected $fillable = ['nome', 'tipo_parentesco_id', 'individuo_id',
		 											 'telefone', 'email', 'endereco', 'bairro'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoParentesco(){
      return $this->belongsTo('TipoParentesco');
    }

}
