<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add7wColumnToEntries extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('entries', function($table) {
			$table->string('who')->nullable();
                        $table->string('what')->nullable();
                        $table->string('where')->nullable();
                        $table->string('which')->nullable();
			$table->string('way')->nullable();
	                $table->string('when')->nullable();
                        $table->string('why')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('entries', function($table) {
			$table->dropColumn('who');
                        $table->dropColumn('what');
                        $table->dropColumn('where');
                        $table->dropColumn('which');
                        $table->dropColumn('way');
                        $table->dropColumn('when');
                        $table->dropColumn('why');
		});
	}

}
