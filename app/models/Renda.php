<?php

class Renda extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'renda';
    protected $fillable = ['numero', 'tipo_renda_id', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

		public function tipoRenda(){
			return $this->belongsTo('TipoRenda', 'tipo_renda_id', 'id');
		}

		public function setNumeroAttribute($numero){
			$this->attributes['numero'] = FormatterHelper::somenteNumeros($numero);
		}

}
