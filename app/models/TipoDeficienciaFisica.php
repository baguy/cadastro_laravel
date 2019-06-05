<?php

class TipoDeficienciaFisica extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_deficiencia_fisica';

    public function deficiencia(){
      return $this->hasOne('Deficiencia', 'fisica_id', 'id');
    }

  }
