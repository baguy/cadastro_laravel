<?php

class Atendimento extends Eloquent {

  use SoftDeletingTrait;

  protected $table = 'atendimento';

  protected $fillable = array('titulo', 'descricao', 'status_id', 'individuo_id', 'user_id', 'email_enviado');

  public function individuo() {
    return $this->belongsTo('Individuo');
  }

  public function documento() {
    return $this->hasOne('Documento', 'individuo_id', 'individuo_id');
  }

  public function user() {
    return $this->belongsTo('User');
  }

  public function setor() {
    return $this->belongsToMany('Setor', 'atendimento_setor_atendimento', 'atendimento_id', 'setor_id');
  }

  public function tipoAtendimento() {
    return $this->belongsToMany('TipoAtendimento', 'atendimento_tipo_atendimento', 'atendimento_id', 'tipo_atendimento_id');
  }

  public function assentamentos() {
    return $this->hasMany('Assentamento');
  }

  public function status() {
    return $this->hasOne('Status', 'id', 'status_id');
  }

  public function endereco(){
    return $this->hasOne('EnderecoAtendimento', 'atendimento_id', 'id');
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

  public function setoresFormatados($setor_assentamento) {
    $setores = '';

    foreach ($setor_assentamento as $key => $value) {
      $setores .= ($key == 0 ? '' : ' | ') . $value->nome;
    }

    return $setores;
  }

  public function ligacoes(){
    return $this->hasMany('Ligacao', 'atendimento_id', 'id');
  }

  public function encerrado(){
    return $this->hasOne('Encerrado', 'atendimento_id', 'id');
  }

}
