<?php

class RegiaoTableSeeder extends Seeder {

  public function run() {

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('regiao')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $objects = array(
      array('regiao' => 'NORTE'),
      array('regiao' => 'SUL'),
      array('regiao' => 'CENTRO'),
    );

    DB::table('regiao')->insert($objects);
  }
}
