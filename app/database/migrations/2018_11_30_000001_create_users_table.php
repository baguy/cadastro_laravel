<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {

    Schema::create('users', function(Blueprint $table) {
      $table->increments('id');
      $table->string('name', 255);
      $table->string('email', 100)->unique();
      $table->string('password', 60);
      $table->rememberToken();
      $table->timestamps();
      $table->softDeletes();

      $table->engine = 'InnoDB';
      $table->charset = 'utf8';
      $table->collation = 'utf8_general_ci'; // utf8_general_ci => performance / utf8_unicode_ci => melhor suporte multi idiomas
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {

    Schema::drop('users');
  }
}