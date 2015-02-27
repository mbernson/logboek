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
			'ex_title' => 'ex_logboek',
			'ex_customer' => 'Opdrachtgever',
			'ex_date' => '01-01-1970',
			'ex_version' => '1.0',
			'ex_disclaimer' => '',
			'ex_disclaimer_html' => '',
			'ex_pdf_sh_evidences' => '1',
			'ex_pdf_sh_coc' => '1',
			'ex_pdf_sh_attachments' => '1',
			'ex_pdf_sh_suspects' => '1',
			'ex_pdf_sh_legals' => '1',
			'ex_html_sh_evidences' => '1',
			'ex_html_sh_coc' => '1',
			'ex_html_sh_attachments' => '1',
			'ex_html_sh_suspects' => '1',
			'ex_html_sh_legals' => '1',

			'menu' => join(';', [
				'entries', 'logbooks', 'tasks',
				'attachments', 'evidences', 'exports',
				'menu', 'settings', 'intro',
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
