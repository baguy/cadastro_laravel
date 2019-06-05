<?php

class ParecerTecnico extends Eloquent {

  	protected $table    = 'parecer_tecnico';
    protected $fillable = ['parecer', 'acompanhante', 'comportamento_funcional', 'individuo_id', 'user_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

		public function user() {
			return $this->belongsTo('User');
		}

}
