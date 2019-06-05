<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCidadeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cidade', function(Blueprint $table)
		{
			$table->increments('id');
			// $table->string('codigo', 5);
			$table->string('nome', 50);

			$table->integer('estado_id')->unsigned();
		});

		Schema::table('cidade', function(Blueprint $table)
		{
			$table->foreign('estado_id')->references('id')->on('estado')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cidade');
	}

}
