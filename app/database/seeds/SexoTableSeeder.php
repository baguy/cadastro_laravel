<?php

class SexoTableSeeder extends Seeder {

  public function run() {

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('sexo')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $objects = array(
      array('tipo' => 'FEMININO'),
      array('tipo' => 'MASCULINO'),
      array('tipo' => 'OUTRO'),
    );

    DB::table('sexo')->insert($objects);
  }
}
