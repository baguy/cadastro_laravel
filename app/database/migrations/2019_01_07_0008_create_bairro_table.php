<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBairroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bairro', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome', 60);

			$table->integer('cidade_id')->unsigned();
			$table->integer('regiao_id')->unsigned();
		});

		Schema::table('bairro', function(Blueprint $table)
		{
			$table->foreign('cidade_id')->references('id')->on('cidade')->onDelete('restrict');
			$table->foreign('regiao_id')->references('id')->on('regiao')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bairro');
	}

}
