<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustodyTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('custody', function($table) {
      $table->longText('log')->after('signature_time')->nullable();
      $table->longText('html_log')->after('log')->nullable();
      $table->string('return')->after('html_log')->default(0);
      $table->string('returned')->after('return')->default(0);
      $table->longText('returned_remark')->after('returned')->nullable();
      $table->longText('html_returned_remark')->after('returned_remark')->nullable();
      $table->string('returned_hash')->after('html_returned_remark')->nullable();
      $table->longText('returned_sign')->after('returned_hash')->nullable();
      $table->string('returned_ip')->after('returned_sign')->nullable();
      $table->date('returned_date')->after('returned_ip')->nullable();
      $table->dateTime('returned_time')->after('returned_date')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('custody', function($table) {
      $table->dropColumn('log');
      $table->dropColumn('html_log');
      $table->dropColumn('return');
      $table->dropColumn('returned');
      $table->dropColumn('returned_remark');
      $table->dropColumn('html_returned_remark');
      $table->dropColumn('returned_hash');
      $table->dropColumn('returned_sign');
      $table->dropColumn('returned_ip');
      $table->dropColumn('returned_date');
      $table->dropColumn('returned_time');
    });
  }

}
