<?php

class UsersRolesTableSeeder extends Seeder {

	public function run() {

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('users_roles')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$objects = array(
			array(
				'user_id' => 1,
				'role_id' => 1
			),
			array(
				'user_id' => 1,
				'role_id' => 2
			),
			array(
				'user_id' => 1,
				'role_id' => 3
			),
		);

		// Uncomment the below to run the seeder
		DB::table('users_roles')->insert($objects);
	}

}
