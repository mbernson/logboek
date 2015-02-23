<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalsTable extends Migration {

  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up() {
    Schema::create('legals', function($table) {
      $table->increments('id');
      $table->string('name');
      $table->longText('body')->nullable();
      $table->longText('html_body')->nullable();
      $table->string('abbreviation')->nullable();
      $table->string('code')->nullable();
      $table->integer('active')->default(0); // Default zero
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down() {
    Schema::drop('legals');
  }

}
