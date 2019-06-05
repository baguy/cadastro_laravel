<?php

class Status extends Eloquent {

  	protected $table = 'status';

    public function atendimento(){
        return $this->hasOne('Atendimento', 'status_id', 'id');
    }

    public function entrada(){
        return $this->hasOne('Atendimento', 'status_id', 'id');
    }
}
