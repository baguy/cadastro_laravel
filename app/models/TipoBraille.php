<?php

class TipoBraille extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_braille';

    public function deficienciaVisual(){
      return $this->hasOne('DeficienciaVisual', 'tipo_braille_id', 'id');
    }

  }
