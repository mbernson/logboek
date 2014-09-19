<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('settings', function($table) {
      $table->increments('id');
      $table->string('project_name');
      $table->integer('vw_menu_entries')->default(1)->nullable();
      $table->integer('vw_menu_logbooks')->default(1)->nullable();
      $table->integer('vw_menu_tasks')->default(1)->nullable();
      $table->integer('vw_menu_attachments')->default(1)->nullable();
      $table->integer('vw_menu_evidences')->default(1)->nullable();
      $table->integer('vw_menu_exports')->default(1)->nullable();
      $table->integer('vw_menu_cipher')->default(1)->nullable();
      $table->integer('vw_menu_settings')->default(1)->nullable();
      $table->integer('vw_menu_intro')->default(1)->nullable();
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
    Schema::drop('settings');
  }

}
