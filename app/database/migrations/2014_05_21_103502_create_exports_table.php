<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
	    Schema::create('exports', function($table) {
		$table->increments('id');
		$table->integer('user_id');

		$table->string('filename');
		$table->string('path');
		$table->integer('filesize'); // In kilobytes

		$table->string('type');

		$table->timestamps();
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
	    Schema::drop('exports');
	}

}
