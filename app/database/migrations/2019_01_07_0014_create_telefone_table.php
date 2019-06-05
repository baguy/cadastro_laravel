<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelefoneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('telefone', function(Blueprint $table)
		{
				$table->increments('id');
				$table->string('ddd', 2);
				$table->string('numero', 9);
				$table->string('ramal', 4)->nullable();

				$table->integer('individuo_id')->unsigned();
				$table->integer('tipo_telefone_id')->unsigned();
		});

		Schema::table('telefone', function(Blueprint $table)
		{
			$table->foreign('individuo_id')->references('id')->on('individuo')->onDelete('restrict');
			$table->foreign('tipo_telefone_id')->references('id')->on('tipo_telefone')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('telefone');
	}

}
