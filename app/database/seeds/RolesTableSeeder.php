<?php

class RolesTableSeeder extends Seeder {

	public function run() {

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('roles')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$objects = array(
			array(
				'name' => 'ROOT'
			),
			array(
				'name' => 'ADMIN'
			),
			array(
				'name' => 'USER'
			),
		);

		// Uncomment the below to run the seeder
		DB::table('roles')->insert($objects);
	}
}
