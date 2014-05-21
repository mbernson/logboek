<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOverviewColumnToLogbooks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('logbooks', function($table) {
			$table->boolean('in_overview')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('logbooks', function($table) {
			$table->dropColumn('in_overview');
		});
	}

}
