<?php

class TipoDocumento extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_documento';

    public function documentos(){
      return $this->hasMany('Documento', 'tipo_telefone_id', 'id');
    }

		public function setTipoDocumentoAttribute($tipo_telefone){
			$this->attributes['tipo_documento'] = DB::table('tipo_documento')->select('id')->where('nome', '=', $tipo_documento)->first()->id;
	   }

  }
