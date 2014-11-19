<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSuspectsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('suspects', function($table) {
      $table->string('street')->after('alias');
      $table->string('city')->after('street');
      $table->string('email')->after('city');
      $table->string('phone')->after('email');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('suspects', function($table) {
      $table->dropColumn('street');
      $table->dropColumn('city');
      $table->dropColumn('email');
      $table->dropColumn('phone');
    });
  }

}
