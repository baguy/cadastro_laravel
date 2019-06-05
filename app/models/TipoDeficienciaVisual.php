<?php

class TipoDeficienciaVisual extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_deficiencia_visual';

    public function deficiencia(){
      return $this->hasOne('Deficiencia', 'visual_id', 'id');
    }

  }
