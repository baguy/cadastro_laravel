<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Setor extends Eloquent {

  use SoftDeletingTrait;
  protected $table = 'setor';
  protected $fillable = array('nome');

  public function atendimento(){
    return $this->belongsToMany('Atendimento', 'atendimento_setor_atendimento', 'setor_id', 'atendimento_id');
  }

  public function assentamento(){
    return $this->belongsToMany('Assentamento', 'assentamento_setor_assentamento', 'setor_id', 'assentamento_id');
  }

  public function funcionario(){
    return $this->belongsToMany('Funcionario', 'setor_funcionario_setor', 'setor_id', 'funcionario_id');
  }

  public function entrada(){
    return $this->belongsToMany('Entrada', 'atendimento_setor_atendimento', 'setor_id', 'atendimento_id');
  }

}
