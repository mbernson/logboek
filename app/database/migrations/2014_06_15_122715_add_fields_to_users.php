<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('users', function($table) {
			$table->string('first_name');
			$table->string('last_name');
			$table->integer('picture_id');
			$table->string('student_number');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function($table) {
			$table->dropColumn('first_name');
			$table->dropColumn('last_name');
			$table->dropColumn('picture_id');
			$table->dropColumn('student_number');
		});
	}

}