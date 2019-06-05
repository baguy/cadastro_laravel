<?php

class Entrada extends Eloquent{

		// public $timestamps  = false;
  	protected $table    = 'atendimento';
    // protected $fillable = array();

		public function user() {
	    return $this->belongsTo('User');
	  }

    public function setor() {
      return $this->belongsToMany('Setor', 'atendimento_setor_atendimento', 'atendimento_id', 'setor_id');
    }

    public function funcionario(){
      return $this->belongsTo('Funcionario', 'setor_funcionario_setor', 'setor_id', 'funcionario_id');
    }

    public function tipoAtendimento() {
      return $this->belongsToMany('TipoAtendimento', 'atendimento_tipo_atendimento', 'atendimento_id', 'tipo_atendimento_id');
    }

    public function status() {
      return $this->hasOne('Status', 'id', 'status_id');
    }

    public function tipoAtendimentoFormatado() {
      $categorias = '';

      foreach ($this->tipoAtendimento as $key => $value) {
        $categorias .= ($key == 0 ? '' : ' | ') . $value->tipo;
      }

      return $categorias;
    }

    public function setorFormatado() {
      $setores = '';

      foreach ($this->setor as $key => $value) {
        $setores .= ($key == 0 ? '' : ' | ') . $value->nome;
      }

      return $setores;
    }

}
