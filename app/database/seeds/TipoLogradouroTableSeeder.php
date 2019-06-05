<?php

class TipoLogradouroTableSeeder extends Seeder {

  public function run() {

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('tipo_logradouro')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $objects = array(
      array(
        'tipo' => 'AREA ESPECIAL',
        'sigla' => 'AE',
      ),
      array(
        'tipo' => 'ALAMEDA',
        'sigla' => 'AL',
      ),
      array(
        'tipo' => 'AVENIDA',
        'sigla' => 'AV',
      ),
      array(
        'tipo' => 'BALNEARIO',
        'sigla' => 'BAL',
      ),
      array(
        'tipo' => 'BECO',
        'sigla' => 'BC',
      ),
      array(
        'tipo' => 'BLOCO',
        'sigla' => 'BL',
      ),
      array(
        'tipo' => 'BOSQUE',
        'sigla' => 'BSQ',
      ),
      array(
        'tipo' => 'CAMINHO',
        'sigla' => 'CAM',
      ),
      array(
        'tipo' => 'CONJUNTO',
        'sigla' => 'CJ',
      ),
      array(
        'tipo' => 'CONDOMINIO',
        'sigla' => 'CON',
      ),
      array(
        'tipo' => 'ESTACIONAMENTO',
        'sigla' => 'ETT',
      ),
      array(
        'tipo' => 'ESTRADA',
        'sigla' => 'EST',
      ),
      array(
        'tipo' => 'FAVELA',
        'sigla' => 'FAV',
      ),
      array(
        'tipo' => 'FAZENDA',
        'sigla' => 'FAZ',
      ),
      array(
        'tipo' => 'ILHA',
        'sigla' => 'IA',
      ),
      array(
        'tipo' => 'JARDIM',
        'sigla' => 'JD',
      ),
      array(
        'tipo' => 'LADEIRA',
        'sigla' => 'LD',
      ),
      array(
        'tipo' => 'LAGO',
        'sigla' => 'LG',
      ),
      array(
        'tipo' => 'LARGO',
        'sigla' => 'LRG',
      ),
      array(
        'tipo' => 'LOTEAMENTO',
        'sigla' => 'LOT',
      ),
      array(
        'tipo' => 'MARGINAL',
        'sigla' => 'MA',
      ),
      array(
        'tipo' => 'PARALELA',
        'sigla' => 'PAR',
      ),
      array(
        'tipo' => 'PARQUE',
        'sigla' => 'PRQ',
      ),
      array(
        'tipo' => 'PRAÇA',
        'sigla' => 'PC',
      ),
      array(
        'tipo' => 'QUADRA',
        'sigla' => 'Q',
      ),
      array(
        'tipo' => 'RUA',
        'sigla' => 'R',
      ),
      array(
        'tipo' => 'RODOVIA',
        'sigla' => 'RD',
      ),
    );

    DB::table('tipo_logradouro')->insert($objects);
  }
}
