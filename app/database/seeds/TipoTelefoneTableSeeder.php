<?php

class TipoTelefoneTableSeeder extends Seeder {

  public function run() {

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('tipo_telefone')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $objects = array(
      array('tipo' => 'RESIDENCIAL'),
      array('tipo' => 'CELULAR'),
      array('tipo' => 'RECADO'),
      array('tipo' => 'COMERCIAL')
    );

    DB::table('tipo_telefone')->insert($objects);
  }
}
