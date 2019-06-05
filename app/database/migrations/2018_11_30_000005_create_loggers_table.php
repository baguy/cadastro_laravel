<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoggersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('loggers', function(Blueprint $table) {
			$table->increments('id');
			$table->string('action', 30);
			$table->string('message', 255);
			$table->integer('user_id')->unsigned()->nullable();
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			
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

		Schema::drop('loggers');
	}
}
