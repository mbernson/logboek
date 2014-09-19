<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuspectsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('suspects', function($table) {
      $table->increments('id');
      $table->string('name');
      $table->string('alias')->nullable();
      $table->softDeletes();
      $table->timestamps();
    });

    DB::insert('insert into settings (project_name) values (?)', [
      'logboek'
    ]);
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('suspects');
  }

}
