<?php

class GrupoSocial extends Eloquent {

		public $timestamps  = false;
  	protected $table    = 'grupo_social';
    protected $fillable = ['outro', 'tipo_grupo_social_id', 'individuo_id'];

    public function individuo(){
      return $this->belongsTo('Individuo');
    }

    public function tipoGrupoSocial(){
      return $this->belongsTo('TipoGrupoSocial', 'tipo_grupo_social_id', 'id');
    }

}
