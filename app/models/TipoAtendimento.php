<?php

class TipoAtendimento extends Eloquent {

  	protected $table = 'tipo_atendimento';

    public function atendimento(){
      return $this->belongsToMany('Atendimento', 'atendimento_tipo_atendimento', 'atendimento_id', 'tipo_atendimento_id');
    }

    public function entrada(){
      return $this->belongsToMany('Atendimento', 'atendimento_tipo_atendimento', 'atendimento_id', 'tipo_atendimento_id');
    }

}
