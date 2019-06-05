<?php

class AtendimentosTableSeeder extends Seeder {

	public function run() {

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('atendimento')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$objects = array(
			array(
				'titulo' => 'Micro não Liga',
				'data_criacao' => new DateTime,
				'descricao' => 'Possivel placa mãe queimada, pois usuário relatou que por conta da chuva, caiu um raio e houve uma apagão.',
				'status_id' => 1,
				'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'individuo_id' => 1,
				'user_id' => 1,
			),

			array(
				'titulo' => 'Montagem de micros novos',
				'data_criacao' => new DateTime,
				'descricao' => 'Montagem de micros novos que já se encontram na unidade e por causa do Levantamento de Infraestrutura (OS - 2472) os micros não haviam sido instalados.',
				'status_id' => 1,
				'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'individuo_id' => 2,
				'user_id' => 1,
			),

			array(
				'titulo' => 'Reset de senha ao E-mail',
				'data_criacao' => new DateTime,
				'descricao' => 'Favor resetar a senha de acesso ao E-mail institucional do(a) usuário(a): Email: salmo.rodrigues@caraguatatuba.sp.gov.br',
				'status_id' => 1,
				'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'individuo_id' => 3,
				'user_id' => 1,
			),

			array(
				'titulo' => 'Criação de Usuário p/ Prescon - Protocolo',
				'data_criacao' => new DateTime,
				'descricao' => 'Favor criar uma conta para acesso ao protocolo',
				'status_id' => 1,
				'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'individuo_id' => 1,
				'user_id' => 1,
			),

			array(
				'titulo' => 'Micro não Liga',
				'data_criacao' => new DateTime,
				'descricao' => 'Micro não está ligando. Favor verificar no local e se necessário, retirar para manutenção em Bancada.',
				'status_id' => 1,
				'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'individuo_id' => 2,
				'user_id' => 1,
			),

			array(
				'titulo' => 'Criação de Acessos à Sistemas',
				'data_criacao' => new DateTime,
				'descricao' => 'Favor criar conta de acesso para o seguinte usuário(a): Nome: Dra Marcela Malta de Lima Barro | Matr: Observar OS 3150.',
				'status_id' => 1,
				'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'individuo_id' => 3,
				'user_id' => 1,
			),

			array(
				'titulo' => 'Impressora com Defeito - Manutenção',
				'data_criacao' => new DateTime,
				'descricao' => 'Usuária informou que a impressora não estava imprimindo e depois voltou ao normal, mas a impressão estava saindo com mancha, então foi passado para que ela fizesse a troca do tonner. Alem disso o scanner não esta funcionando e a tampa da impressora não fecha.',
				'status_id' => 1,
				'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'individuo_id' => 1,
				'user_id' => 1,
			)
		);

		// Uncomment the below to run the seeder
		DB::table('atendimento')->insert($objects);
	}

}
