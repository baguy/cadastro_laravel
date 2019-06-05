<?php

class TipoEncerrado extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_encerrado';

    public function encerrado(){
      return $this->hasOne('Encerrado', 'tipo_encerrado_id', 'id');
    }

  }
