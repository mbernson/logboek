<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletionToEntriesAndTasks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('entries', function($table) {
			$table->softDeletes();
		});
		Schema::table('tasks', function($table) {
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('entries', function($table) {
			$table->dropColumn('deleted_at');
		});
		Schema::table('tasks', function($table) {
			$table->dropColumn('deleted_at');
		});
	}

}
