<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustodyTable extends Migration {

  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up() {
    Schema::create('custody', function($table) {
      $table->increments('id');
      $table->string('name');
      $table->string('characteristic');
      $table->string('responsible');
      $table->date('date');
      $table->dateTime('time')->nullable();
      $table->longText('description')->nullable();
      $table->longText('html_description')->nullable();
      $table->longText('details')->nullable();
      $table->longText('html_details')->nullable();
      $table->string('signed')->default(0); // Default zero
      $table->string('signed_ip')->nullable();
      $table->string('signed_hash')->nullable();
      $table->longText('signed_sign')->nullable(); // Here stores sign
      $table->integer('signature')->default(0); // Default zero
      $table->string('signature_name')->nullable();
      $table->longText('signature_remark')->nullable();
      $table->longText('html_signature_remark')->nullable();
      $table->string('signature_signed')->nullable();
      $table->string('signature_signed_ip')->nullable();
      $table->date('signature_signed_date')->nullable();
      $table->dateTime('signature_signed_time')->nullable();
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
    Schema::drop('custody');
  }

}
