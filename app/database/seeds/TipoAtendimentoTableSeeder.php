<?php

class TipoAtendimentoTableSeeder extends Seeder {

  public function run() {

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('tipo_atendimento')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $objects = array(
      array('tipo' => 'ADMINISTRAÇÃO'),
      array('tipo' => 'ASSUNTOS JURÍDICOS'),
      array('tipo' => 'COMUNICAÇÃO SOCIAL'),
      array('tipo' => 'DESENVOLVIMENTO SOCIAL E CIDADANIA'),
      array('tipo' => 'EDUCAÇÃO'),
      array('tipo' => 'ESPORTES E RECREAÇÃO'),
      array('tipo' => 'FAZENDA (serviços tributários)'),
      array('tipo' => 'GOVERNO'),
      array('tipo' => 'HABITAÇÃO'),
      array('tipo' => 'MEIO AMBIENTE'),
      array('tipo' => 'OBRAS'),
      array('tipo' => 'PESSOA COM DEFICIÊNCIA E IDOSOS'),
      array('tipo' => 'PLANEJAMENTO'),
      array('tipo' => 'SAÚDE'),
      array('tipo' => 'SERVIÇOS PÚBLICOS'),
      array('tipo' => 'TECNOLOGIA DA INFORMAÇÃO'),
      array('tipo' => 'MOBILIDADE URBANA E PROTEÇÃO AO CIDADÃO'),
      array('tipo' => 'TURISMO'),
      array('tipo' => 'URBANISMO'),
      array('tipo' => 'INFRAESTRUTURA'),
      array('tipo' => 'RECLAMAÇÕES'),
      array('tipo' => 'DIVERSOS')
    );

    DB::table('tipo_atendimento')->insert($objects);
  }
}
