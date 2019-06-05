<?php

class TipoDeficienciaMental extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_deficiencia_mental';

    public function deficiencia(){
      return $this->hasOne('Deficiencia', 'mental_id', 'id');
    }

  }
