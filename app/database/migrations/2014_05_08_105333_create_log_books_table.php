<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
	    Schema::create('logbooks', function($table) {
		$table->increments('id');
		$table->string('title');

		$table->integer('user_id');

		$table->timestamps();
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
	    Schema::drop('logbooks');
	}

}
