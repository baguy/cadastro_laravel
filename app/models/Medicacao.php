<?php

class Medicacao extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'medicacao';
    protected $fillable = ['nome', 'processo_farmacia_municipal', 'individuo_id', 'tipo_medicacao_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

		public function tipoMedicacao(){
			return $this->belongsTo('TipoMedicacao', 'tipo_medicacao_id', 'id');
		}

}
