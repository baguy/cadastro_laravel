<?php

class VidaDiaria extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'vida_diaria';
    protected $fillable = ['tipo_vida_diaria_id', 'tipo_vida_diaria_assunto_id', 'outro', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoVidaDiaria(){
      return $this->belongsTo('TipoVidaDiaria', 'tipo_vida_diaria_id', 'id');
    }

    public function tipoVidaDiariaAssunto(){
      return $this->belongsTo('TipoVidaDiariaAssunto', 'tipo_vida_diaria_assunto_id', 'id');
    }

}
