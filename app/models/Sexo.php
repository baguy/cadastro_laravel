<?php

class Sexo extends Eloquent {

  	protected $table    = 'sexo';

    public function individuo(){
        return $this->hasOne('Individuos', 'sexo_id', 'id');
    }
}
