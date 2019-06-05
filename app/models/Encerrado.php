<?php

class Encerrado extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'encerrado';
    protected $fillable = ['tipo_encerrado_id', 'atendimento_id'];

    public function atendimento(){
      return $this->belongsTo('Atendimento');
    }

		public function tipoEncerrado(){
			return $this->belongsTo('TipoEncerrado', 'tipo_encerrado_id', 'id');
		}

}
