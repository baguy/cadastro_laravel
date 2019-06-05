<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotAtendimentoTipoAtendimentoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('atendimento_tipo_atendimento', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('atendimento_id')->unsigned()->index();
			$table->integer('tipo_atendimento_id')->unsigned()->index();
		});

		Schema::table('atendimento_tipo_atendimento', function(Blueprint $table)
		{
			$table->foreign('atendimento_id')->references('id')->on('atendimento')->onDelete('restrict');
			$table->foreign('tipo_atendimento_id')->references('id')->on('tipo_atendimento')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('atendimento_tipo_atendimento');
	}

}
