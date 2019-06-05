<?php

class IndividuosTableSeeder extends Seeder {

	public function run() {

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('individuo')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$objects = array(
			array(
				'nome' => 'NIKOLAS',
				'data_nascimento' => date('Y-m-d'),
				'email' => 'nikolas@gmail.com',
				'cpf' => '38391928895',
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'sexo_id' => 2,
			),

			array(
				'nome' => 'MARCELLA',
				'data_nascimento' => date('Y-m-d'),
				'email' => 'marcella@gmail.com',
				'cpf' => '38356988569',
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'sexo_id' => 1,
			),

			array(
				'nome' => 'DEBORAH',
				'data_nascimento' => date('Y-m-d'),
				'email' => 'deborah@gmail.com',
				'cpf' => '38356988556',
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'sexo_id' => 1,
			)
		);

		// Uncomment the below to run the seeder
		DB::table('individuo')->insert($objects);
	}

}
