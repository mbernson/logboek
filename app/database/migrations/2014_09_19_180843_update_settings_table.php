<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Setting::truncate();

		Schema::table('settings', function(Blueprint $table) {
			$table->string('key')->unique();
			$table->string('value')->nullable();
		});

		$settings = [
			'project_name' => 'Logboek',
			'ex_pdf_title' => 'ex_logboek',
			'ex_pdf_customer' => 'Opdrachtgever',
			'ex_pdf_date' => '01-01-1970',
			'ex_pdf_version' => '1.0',
			'ex_pdf_disclaimer' => '',
			'ex_pdf_disclaimer_html' => '',
			'ex_pdf_sh_evidences' => '1',
			'ex_pdf_sh_attachments' => '1',
			'ex_pdf_sh_suspects' => '1',

			'menu' => join(';', [
				'entries', 'logbooks', 'tasks',
				'attachments', 'evidences', 'exports',
				'cipher', 'settings', 'intro',
			])
		];

		foreach($settings as $key => $value) {
			Setting::create([
				'key' => $key,
				'value' => $value
			]);
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Setting::truncate();

		Schema::table('settings', function(Blueprint $table) {
			$table->dropColumn('key');
			$table->dropColumn('value');
		});
	}

}
