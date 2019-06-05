<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssentamentoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assentamento', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('descricao');
			$table->timestamps();
			$table->softDeletes();

			$table->integer('user_id')->unsigned();
			$table->integer('atendimento_id')->unsigned();
		});

		Schema::table('assentamento', function(Blueprint $table)
		{
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
			$table->foreign('atendimento_id')->references('id')->on('atendimento')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('assentamento');
	}

}
