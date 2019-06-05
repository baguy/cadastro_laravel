<?php

class AssentamentoTableSeeder extends Seeder {

  public function run() {

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('assentamento')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $objects = array(
      array(
        'descricao' => 'Placa de rede provavelmente queimada devido a queda de raios..',
        'user_id' => 1,
        'atendimento_id' => 1,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
      ),

      array(
        'descricao' => 'Micro não está ligando. Favor verificar no local e se necessário, retirar para manutenção em Bancada.',
        'user_id' => 1,
        'atendimento_id' => 1,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
      ),

      array(
        'descricao' => 'Placa de rede provavelmente queimada devido a queda de raios..',
        'user_id' => 1,
        'atendimento_id' => 2,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
      ),

      array(
        'descricao' => 'Placa de rede provavelmente queimada devido a queda de raios..',
        'user_id' => 1,
        'atendimento_id' => 2,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
      ),

      array(
        'descricao' => 'Micro não está ligando. Favor verificar no local e se necessário, retirar para manutenção em Bancada.',
        'user_id' => 1,
        'atendimento_id' => 2,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
      ),

      array(
        'descricao' => 'Micro não está ligando. Favor verificar no local e se necessário, retirar para manutenção em Bancada.',
        'user_id' => 1,
        'atendimento_id' => 3,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
      ),

      array(
        'descricao' => 'Placa de rede provavelmente queimada devido a queda de raios..',
        'user_id' => 1,
        'atendimento_id' => 3,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
      ),

      array(
        'descricao' => 'Micro não está ligando. Favor verificar no local e se necessário, retirar para manutenção em Bancada.',
        'user_id' => 1,
        'atendimento_id' => 4,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
      ),

      array(
        'descricao' => 'Placa de rede provavelmente queimada devido a queda de raios..',
        'user_id' => 1,
        'atendimento_id' => 4,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
      ),

      array(
        'descricao' => 'Micro não está ligando. Favor verificar no local e se necessário, retirar para manutenção em Bancada.',
        'user_id' => 1,
        'atendimento_id' => 5,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
      ),
    );

    DB::table('assentamento')->insert($objects);
  }
}
