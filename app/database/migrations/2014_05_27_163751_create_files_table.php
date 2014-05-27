<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('files', function($table) {
			$table->increments('id');
			$table->integer('user_id'); // The file's owner

			$table->string('title')->nullable();
			$table->text('description')->nullable();

			$table->string('type')->default('File'); // Corresponds to a class such as 'Image'

			$table->string('filename');
			$table->string('path');
			$table->bigInteger('filesize'); // In bytes
			$table->string('extension');

			$table->string('hash');
			$table->string('hash_algorithm');

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('files');
	}

}
