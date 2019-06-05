<?php

class Visual extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'visual';
    protected $fillable = ['tipo_deficiencia_visual_id', 'tipo_braille_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function deficiencias(){
      return $this->hasMany('Deficiencias', 'id', 'visual_id');
    }

    public function tipoDeficienciaVisual(){
      return $this->belongsTo('TipoDeficienciaVisual', 'id', 'tipo_deficiencia_visual_id');
    }

    public function tipoBraille(){
      return $this->belongsTo('TipoBraille', 'id', 'tipo_braille_id');
    }

}
