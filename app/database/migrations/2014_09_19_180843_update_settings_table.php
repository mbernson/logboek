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
			$table->dropColumn('project_name');
			$table->dropColumn('vw_menu_entries');
			$table->dropColumn('vw_menu_logbooks');
			$table->dropColumn('vw_menu_tasks');
			$table->dropColumn('vw_menu_attachments');
			$table->dropColumn('vw_menu_evidences');
			$table->dropColumn('vw_menu_exports');
			$table->dropColumn('vw_menu_cipher');
			$table->dropColumn('vw_menu_settings');
			$table->dropColumn('vw_menu_intro');

			$table->string('key')->unique();
			$table->string('value')->nullable();

		});

		$settings = [
			'project_name' => 'Logboek',
			'ex_pdf_title' => 'ex_logboek',
			'ex_pdf_customer' => 'Opdrachtgever',
			'ex_pdf_date' => '01-01-1970',
			'ex_pdf_version' => '1.0',
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

			$table->string('project_name');
			$table->integer('vw_menu_entries')->default(1)->nullable();
			$table->integer('vw_menu_logbooks')->default(1)->nullable();
			$table->integer('vw_menu_tasks')->default(1)->nullable();
			$table->integer('vw_menu_attachments')->default(1)->nullable();
			$table->integer('vw_menu_evidences')->default(1)->nullable();
			$table->integer('vw_menu_exports')->default(1)->nullable();
			$table->integer('vw_menu_cipher')->default(1)->nullable();
			$table->integer('vw_menu_settings')->default(1)->nullable();
			$table->integer('vw_menu_intro')->default(1)->nullable();
		});
	}

}
