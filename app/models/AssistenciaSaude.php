<?php

class AssistenciaSaude extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'saude';
    protected $fillable = ['tipo_saude_id', 'individuo_id', 'tipo_transporte_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoSaude(){
      return $this->belongsTo('TipoSaude', 'tipo_saude_id', 'id');
    }

		public function tipoTransporte(){
      return $this->belongsTo('TipoTransporte', 'tipo_transporte_id', 'id');
    }

}
