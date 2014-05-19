<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSystemUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		$system = DB::select('select * from users where id = 0');
		if(count($system) == 0) {
			DB::statement("SET SESSION sql_mode='NO_AUTO_VALUE_ON_ZERO'");
			DB::insert('insert into users (id, username, email, password) values (?, ?, ?, ?)', [
				0, 'systeem', 'system@example.com', ''
			]);
			DB::statement("SET SESSION sql_mode=''");
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::delete('delete from users where id = 0 limit 1');
	}

}
