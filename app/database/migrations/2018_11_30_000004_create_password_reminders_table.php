<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordRemindersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('password_reminders', function(Blueprint $table) {
			$table->string('email', 100)->index();
			$table->string('token')->index();
			$table->timestamp('created_at');

			$table->engine = 'InnoDB';
			$table->charset = 'utf8';
			$table->collation = 'utf8_general_ci'; // utf8_general_ci => performance / utf8_unicode_ci => melhor suporte multi idiomas
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::drop('password_reminders');
	}
}