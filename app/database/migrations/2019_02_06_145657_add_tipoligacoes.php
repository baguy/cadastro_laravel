<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoligacoes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipo_ligacao', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('tipo', 50);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tipo_ligacao', function(Blueprint $table)
		{
			//
		});
	}

}
