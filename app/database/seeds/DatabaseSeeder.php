<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		Eloquent::unguard();

		$this->call('UsersTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('UsersRolesTableSeeder');
		$this->call('ThrottlesTableSeeder');
		$this->call('StatusTableSeeder');
		$this->call('TipoEstadoCivilTableSeeder');
		$this->call('TipoLogradouroTableSeeder');
		$this->call('TipoTelefoneTableSeeder');
		$this->call('SexoTableSeeder');
		$this->call('TipoAtendimentoTableSeeder');
		$this->call('IndividuosTableSeeder');
		$this->call('AtendimentosTableSeeder');
		$this->call('AtendimentoTipoAtendimentoTableSeeder');
		$this->call('AssentamentoTableSeeder');
		$this->call('RegiaoTableSeeder');
		$this->call('TipoLigacoesTableSeeder');

	}

}
