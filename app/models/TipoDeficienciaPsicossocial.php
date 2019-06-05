<?php

class TipoDeficienciaPsicossocial extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_deficiencia_psicossocial';

    public function deficiencia(){
      return $this->hasOne('Deficiencia', 'psicossocial_id', 'id');
    }

  }
