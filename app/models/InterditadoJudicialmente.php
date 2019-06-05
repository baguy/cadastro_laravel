<?php

class InterditadoJudicialmente extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'interditado';
    protected $fillable = ['curador', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

}
