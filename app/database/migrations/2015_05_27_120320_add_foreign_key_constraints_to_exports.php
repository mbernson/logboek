<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyConstraintsToExports extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE exports MODIFY COLUMN user_id INT(10) UNSIGNED');
		Schema::table('exports', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('exports', function(Blueprint $table) {
			$table->dropForeign('exports_user_id_foreign');
		});
		DB::statement('ALTER TABLE exports MODIFY COLUMN user_id INT(11)');
	}

}
