<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function($table) {
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('username', 16)->unique();
			$table->string('password', 64);
			$table->integer('rights')->default(0); // Default user rights

			$table->string('remember_token', 100)->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('users');
	}

}
