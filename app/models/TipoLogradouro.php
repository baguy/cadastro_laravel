<?php

class TipoLogradouro extends Eloquent {

  	protected $table = 'tipo_logradouro';

    public function endereco(){
      return $this->hasMany('Endereco', 'tipo_logradouro_id', 'id');
    }

}
