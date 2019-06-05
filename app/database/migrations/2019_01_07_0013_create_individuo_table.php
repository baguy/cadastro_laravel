<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividuoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('individuo', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome', 100);
			$table->string('email', 150)->nullable();
			$table->date('data_nascimento')->nullable();
			$table->string('cpf', 30)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('sexo_id')->unsigned()->nullable();
		});

		Schema::table('individuo', function(Blueprint $table)
		{
			$table->foreign('sexo_id')->references('id')->on('sexo')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('individuo');
	}

}
