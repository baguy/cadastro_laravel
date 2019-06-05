<?php

class TipoLigacoesTableSeeder extends Seeder {

  public function run() {

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('tipo_ligacao')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $objects = array(
      array('tipo' => 'MAL SUCEDIDA'),
      array('tipo' => 'BEM SUCEDIDA'),
      array('tipo' => 'RETORNAR'),
      array('tipo' => 'NÃO LIGAR'),
    );

    DB::table('tipo_ligacao')->insert($objects);
  }
}
