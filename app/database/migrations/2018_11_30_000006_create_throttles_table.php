<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThrottlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('throttles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('ip_address', 35)->nullable();
			$table->timestamp('last_access_at')->nullable();
			$table->tinyInteger('attempts')->default(0);
			$table->timestamp('last_attempt_at')->nullable();
			$table->boolean('suspended')->default(0);
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

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

		Schema::drop('throttles');
	}
}
