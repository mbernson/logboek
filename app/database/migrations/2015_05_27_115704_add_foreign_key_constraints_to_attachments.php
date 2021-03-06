<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyConstraintsToAttachments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE attachments MODIFY COLUMN user_id INT(10) UNSIGNED');
		Schema::table('attachments', function(Blueprint $table) {
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
		Schema::table('attachments', function(Blueprint $table) {
			$table->dropForeign('attachments_user_id_foreign');
		});
		DB::statement('ALTER TABLE attachments MODIFY COLUMN user_id INT(11)');
	}

}
