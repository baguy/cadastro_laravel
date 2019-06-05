<?php

class Documento extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'documento';
    protected $fillable = array('id', 'numero', 'individuo_id', 'tipo_documento_id');

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoDocumento(){
      return $this->belongsTo('TipoDocumento', 'tipo_documento_id', 'id' );
    }

		// public function getNumeroAttribute(){
		// 	if($this->attributes['tipo_documento_id'] == 1){
		// 		return FormatterHelper::setCPF($this->attributes['numero']);
		// 	}
		// }

		public function setNumeroAttribute($numero){
			$this->attributes['numero'] = FormatterHelper::somenteNumeros($numero);
		}

		public function getTipoDocumento($tipo_documento_id){
			$doc = null;
			if( $tipo_documento_id == 1 ){
				$doc = 'CPF';
			}
			if( $tipo_documento_id == 2 ){
				$doc = 'NIS';
			}
			if( $tipo_documento_id == 3 ){
				$doc = 'SUS';
			}
			return $doc;
		}

}
