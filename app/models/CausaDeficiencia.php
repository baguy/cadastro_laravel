<?php

class CausaDeficiencia extends Eloquent {

    public $timestamps = false;
  	protected $table   = 'causa_deficiencia';

    public function deficienciaFisica(){
      return $this->hasOne('DeficienciaFisica', 'causa_id', 'id' );
    }

    public function deficienciaMental(){
      return $this->hasOne('DeficienciaMental', 'causa_id', 'id' );
    }

    public function deficienciaPsicossocial(){
      return $this->hasOne('DeficienciaPsicossocial', 'causa_id', 'id' );
    }

    public function deficienciaAuditiva(){
      return $this->hasOne('DeficienciaAuditiva', 'causa_id', 'id' );
    }

    public function deficienciaVisual(){
      return $this->hasOne('DeficienciaVisual', 'causa_id', 'id' );
    }

    public function setCausaDeficienciaAttribute($causa_id){
      $this->attributes['causa_deficiencia'] = DB::table('causa_deficiencia')->select('id')->where('nome', '=', $causa_id)->first()->id;
    }

  }
