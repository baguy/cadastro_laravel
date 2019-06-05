<?php

class Assentamento extends Eloquent {

  use SoftDeletingTrait;

  protected $table = 'assentamento';

  protected $fillable = array('descricao', 'atendimento_id', 'user_id');

  public function atendimento() {
    return $this->belongsTo('Atendimento');
  }

  public function user() {
    return $this->belongsTo('User');
  }

  public function ligacoes(){
    return $this->hasMany('Ligacao', 'assentamento_id', 'id');
  }

  public function setor() {
    return $this->belongsToMany('Setor', 'assentamento_setor_assentamento', 'assentamento_id', 'setor_id');
  }

}
