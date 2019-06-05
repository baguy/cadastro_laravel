<?php

class TecnologiaAssistiva extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'tecnologia_assistiva';
    protected $fillable = ['tipo_tecnologia_assistiva_id', 'outro', 'individuo_id', 'prefeitura'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoTecnologiaAssistiva(){
      return $this->belongsTo('TipoTecnologiaAssistiva', 'tipo_tecnologia_assistiva_id', 'id');
    }

}
