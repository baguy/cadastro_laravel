<?php

class Bairro extends Eloquent{

		public $timestamps = false;
  	protected $table    = 'bairro';
    protected $fillable = array('nome');

    public function cidade(){
      return $this->belongsTo('Cidade');
    }

		public function endereco(){
			return $this->belongsTo('Endereco');
		}

}
