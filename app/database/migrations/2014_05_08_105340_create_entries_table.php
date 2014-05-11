<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
	    Schema::create('entries', function($table) {
		$table->increments('id');
		$table->string('title')->nullable();
		$table->longText('body')->nullable();
		$table->longText('html_body')->nullable();

		$table->timestamp('started_at');
		$table->timestamp('finished_at');

		$table->integer('logbook_id');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
	    Schema::drop('entries');
	}

}
