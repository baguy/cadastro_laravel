<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLigacoes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ligacao', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->integer('individuo_id')->unsigned();
			$table->integer('tipo_ligacao_id')->unsigned();
		});

		Schema::table('ligacao', function(Blueprint $table)
		{
			$table->foreign('individuo_id')->references('id')->on('individuo')->onDelete('restrict');
			$table->foreign('tipo_ligacao_id')->references('id')->on('tipo_ligacao')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ligacao', function(Blueprint $table)
		{
			//
		});
	}

}
