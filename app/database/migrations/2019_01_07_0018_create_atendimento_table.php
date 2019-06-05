<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtendimentoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('atendimento', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('titulo', 202);
			$table->date('data_criacao');
			$table->text('descricao');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('user_id')->unsigned();
			$table->integer('status_id')->unsigned();
			$table->integer('individuo_id')->unsigned();
		});

		Schema::table('atendimento', function(Blueprint $table)
		{
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
			$table->foreign('status_id')->references('id')->on('status')->onDelete('restrict');
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
		Schema::drop('atendimento');
	}

}
