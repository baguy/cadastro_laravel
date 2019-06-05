<?php

class Ligacao extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'ligacao';
    protected $fillable = array('tipo_ligacao_id', 'individuo_id', 'atendimento_id', 'assentamento_id', 'created_at');

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

		public function atendimento(){
			return $this->belongsTo('Atendimento');
		}

    public function tipoLigacao(){
      return $this->belongsTo('TipoLigacao');
    }

		public function assentamento(){
			return $this->belongsTo('Assentamento');
		}

}
