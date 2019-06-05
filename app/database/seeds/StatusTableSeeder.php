<?php

class StatusTableSeeder extends Seeder {

  public function run() {

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('status')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $objects = array(
      array('tipo' => 'ABERTO'),
      array('tipo' => 'PENDENTE'),
      array('tipo' => 'ENCAMINHADO'),
      array('tipo' => 'ENCERRADO')
    );

    DB::table('status')->insert($objects);
  }
}
