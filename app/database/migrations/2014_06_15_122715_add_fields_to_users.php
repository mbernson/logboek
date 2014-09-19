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
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->integer('picture_id')->nullable();
			$table->string('student_number')->nullable();
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
