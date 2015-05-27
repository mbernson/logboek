<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyConstraintsToTasks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE tasks MODIFY COLUMN user_id INT(10) UNSIGNED');
		Schema::table('tasks', function(Blueprint $table) {
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
		Schema::table('tasks', function(Blueprint $table) {
			$table->dropForeign('tasks_user_id_foreign');
		});
		DB::statement('ALTER TABLE tasks MODIFY COLUMN user_id INT(11)');
	}

}
