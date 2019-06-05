<?php

class Acompanhamento extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'acompanhamento';
    protected $fillable = ['medico', 'terapeutico', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

}
