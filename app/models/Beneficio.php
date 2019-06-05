<?php

class Beneficio extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'beneficio';
    protected $fillable = ['tipo_beneficio_id', 'outro', 'individuo_id', 'obs'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoBeneficio(){
      return $this->belongsTo('TipoBeneficio', 'tipo_beneficio_id', 'id');
    }

}
