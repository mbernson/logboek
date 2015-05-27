<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyConstraintsToEntries extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE entries MODIFY COLUMN logbook_id INT(10) UNSIGNED');
		Schema::table('entries', function(Blueprint $table) {
			$table->foreign('logbook_id')->references('id')->on('logbooks')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('entries', function(Blueprint $table) {
			$table->dropForeign('entries_logbook_id_foreign');
		});
		DB::statement('ALTER TABLE entries MODIFY COLUMN logbook_id INT(11)');
	}

}
