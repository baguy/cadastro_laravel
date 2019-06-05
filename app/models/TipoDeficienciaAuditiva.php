<?php

class TipoDeficienciaAuditiva extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'tipo_deficiencia_auditiva';

    public function deficiencia(){
      return $this->hasOne('Deficiencia', 'auditiva_id', 'id');
    }

  }
