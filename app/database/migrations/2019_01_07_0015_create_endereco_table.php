<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('endereco', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('cep')->nullable();
			$table->integer('numero');
			$table->string('logradouro', 100);
			$table->string('complemento', 120);

			$table->integer('cidade_id')->unsigned();
			$table->integer('tipo_logradouro_id')->unsigned()->nullable();
			$table->integer('individuo_id')->unsigned();
			$table->string('bairro', 30)->nullable();
			$table->integer('bairro_id')->unsigned()->nullable();

			$table->string('latitude', 30)->nullable();
			$table->string('longitude', 30)->nullable();
		});

		Schema::table('endereco', function(Blueprint $table)
		{
			$table->foreign('cidade_id')->references('id')->on('cidade')->onDelete('restrict');
			$table->foreign('tipo_logradouro_id')->references('id')->on('tipo_logradouro')->onDelete('restrict');
			$table->foreign('individuo_id')->references('id')->on('individuo')->onDelete('restrict');
			$table->foreign('bairro_id')->references('id')->on('bairro')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('endereco');
	}

}
