<?php

class TipoEstadoCivilTableSeeder extends Seeder {

  public function run() {

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('tipo_estado_civil')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $objects = array(
      array('estado' => 'SOLTEIRO(A)'),
      array('estado' => 'DIVORCIADO(A)'),
      array('estado' => 'SEPARADO(A) JUDICIALMENTE'),
      array('estado' => 'VIUVO(A)'),
      array('estado' => 'COM UNIÃO ESTÁVEL'),
      array('estado' => 'CASADO(A) COMUNHÃO TOTAL DE BENS'),
      array('estado' => 'CASADO(A) SEM COMUNHÃO TOTAL DE BENS'),
      array('estado' => 'CASADO(A) COMUNHÃO PARCIAL DE BENS'),
    );

    DB::table('tipo_estado_civil')->insert($objects);
  }
}
