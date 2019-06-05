<?php

class TipoVidaDiariaAssunto extends Eloquent {

  	protected $table = 'tipo_vida_diaria_assunto';

    public function vidaDiaria(){
        return $this->hasMany('VidaDiaria', 'tipo_vida_diaria_assunto_id', 'id');
    }

}
