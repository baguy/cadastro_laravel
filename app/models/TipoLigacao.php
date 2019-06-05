<?php

class TipoLigacao extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_ligacao';

    public function ligacao(){
      return $this->hasMany('Ligacao', 'tipo_ligacao_id', 'id');
    }

  }
