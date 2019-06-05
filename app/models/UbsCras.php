<?php

class UbsCras extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'ubs_cras';
    protected $fillable = ['ubs', 'cras', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

}
