<?php

class TipoDeficiencia extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_deficiencia';

    public function deficiencias(){
      return $this->hasMany('Deficiencia', 'tipo_deficiencia_id', 'id');
    }

  }
