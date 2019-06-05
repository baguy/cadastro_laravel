<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Funcionario extends Eloquent {

  use SoftDeletingTrait;
  public $timestamps = true;
  protected $table = 'funcionario';
  protected $fillable = array('nome', 'matricula', 'email');

  public function setor(){
    return $this->belongsToMany('Setor', 'setor_funcionario_setor', 'funcionario_id', 'setor_id');
  }

  public function atendimentos(){
    return $this->hasMany('Atendimento', 'user_id', 'id');
  }

  public function user(){
    return $this->hasOne('User');
  }

  public function entrada(){
    return $this->hasOne('Entrada');
  }

  public function setorFormatado() {
    $setor = '';

    foreach ($this->setor as $key => $value) {
      $setor .= ($key == 0 ? '' : ' | ') . $value->nome;
    }

    return $setor;
  }

}
