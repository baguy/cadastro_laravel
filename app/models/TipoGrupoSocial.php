<?php

class TipoGrupoSocial extends Eloquent {

  	protected $table = 'tipo_grupo_social';

    public function grupoSociais(){
        return $this->hasMany('GrupoSocial', 'tipo_grupo_social_id', 'id');
    }

    public function setTipoGrupoSocialAttribute($tipo_grupo_social){
      $this->attributes['tipo_grupo_social'] = DB::table('tipo_grupo_social')->select('id')->where('nome', '=', $tipo_grupo_social)->first()->id;
    }

}
