<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvidencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
	    Schema::create('evidences', function($table) {
		$table->increments('id');
		$table->string('title');
		$table->string('hash');

		$table->timetamp('date_received');
		$table->string('sender');

		$table->text('original_message');
		$table->text('html_original_message');
		$table->text('encrypted_message');
		$table->text('html_encrypted_message');

		$table->text('software');

		$table->timestamps();
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
	    Schema::drop('evidences');
	}

}
