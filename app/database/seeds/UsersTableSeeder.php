<?php

class UsersTableSeeder extends Seeder {

	public function run() {

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('users')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$objects = array(
			array(
				'name' => 'MAYRA',
				'email' => 'mayradbueno@gmail.com',
				'password' => Hash::make('123456')
			),
		);

		// Uncomment the below to run the seeder
		DB::table('users')->insert($objects);
	}

}
