<?php

class ThrottlesTableSeeder extends Seeder {

	public function run() {

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('throttles')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$objects = array(
			array(
				'ip_address'      => null,
				'last_access_at'  => null,
				'attempts'        => 0,
				'last_attempt_at' => null,
				'suspended'       => 0,
				'user_id'         => 1
			)
		);

		// Uncomment the below to run the seeder
		DB::table('throttles')->insert($objects);
	}

}
