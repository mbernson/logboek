<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublicColumnToAttachments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('attachments', function($table) {
			$table->boolean('public')->default(false);
		});
		DB::update('update attachments set public = 0 where public is null');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('attachments', function($table) {
			$table->dropColumn('public');
		});
	}

}
