<?php

class Sugestao extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'sugestao';
    protected $fillable = ['sugestao', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

}
