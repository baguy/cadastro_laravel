<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoCivilTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('estado_civil', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('data_casamento')->nullable();

			$table->integer('tipo_estado_civil_id')->unsigned();
			$table->integer('individuo_id')->unsigned();
		});

		Schema::table('estado_civil', function(Blueprint $table)
		{
			$table->foreign('tipo_estado_civil_id')->references('id')->on('tipo_estado_civil')->onDelete('restrict');
			$table->foreign('individuo_id')->references('id')->on('individuo')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('estado_civil');
	}

}
