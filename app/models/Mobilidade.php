<?php

class Mobilidade extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'mobilidade';
    protected $fillable = ['causa_mobilidade_id','individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function causaMobilidade(){
      return $this->belongsTo('CausaMobilidade', 'causa_mobilidade_id', 'id');
    }

}
