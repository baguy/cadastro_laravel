<?php

class AtendimentoTipoAtendimentoTableSeeder extends Seeder {

  public function run() {

    $objects = array(
      array(
        'atendimento_id' => 1,
        'tipo_atendimento_id' => 1
      ),

      array(
        'atendimento_id' => 2,
        'tipo_atendimento_id' => 2
      ),

      array(
        'atendimento_id' => 3,
        'tipo_atendimento_id' => 3
      ),

      array(
        'atendimento_id' => 4,
        'tipo_atendimento_id' => 4
      ),

      array(
        'atendimento_id' => 5,
        'tipo_atendimento_id' => 1
      ),

      array(
        'atendimento_id' => 6,
        'tipo_atendimento_id' => 2
      ),

      array(
        'atendimento_id' => 7,
        'tipo_atendimento_id' => 3
      ),

    );

    DB::table('atendimento_tipo_atendimento')->insert($objects);
  }
}
