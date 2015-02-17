<?php

class SettingsController extends \BaseController {

	public function __construct() {
		parent::__construct();

		$users = User::orderBy('username')
			->paginate(self::$per_page);

		$legals = Legal::orderBy('id')
			->paginate(self::$per_page);

		$this->features = [
			'entries', 'logbooks', 'tasks',
			'attachments', 'evidences', 'exports',
			'tools'
		];

		$this->export_features = [
			'ex_pdf_title', 'ex_pdf_customer', 'ex_pdf_date',
			'ex_pdf_version', 'ex_pdf_disclaimer', 'ex_pdf_sh_evidences',
			'ex_pdf_sh_attachments', 'ex_pdf_sh_suspects'
		];

		View::share('users', $users);
		View::share('settings', Setting::all());
		View::share('suspects', Suspect::all());
		View::share('features', $this->features);
		View::share('legals', $legals);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		return View::make('settings.index');
	}

	private function updateMenuSettings() {
		$features = [];
		$input = Input::only($this->features);

		foreach($input as $feature => $enabled)
			if($enabled) $features[] = $feature;

		$input = join(';', $features);

		return Setting::set('menu', $input);
	}

	private function updateExportSettings() {
		$input = Input::only($this->export_features);

		$input['ex_pdf_disclaimer_html'] = Markdown::string($input['ex_pdf_disclaimer']);

			foreach($input as $key => $value) {
					Setting::set($key, $value);
			}
		return true;
	}

	public function update($setting_id) {
		$succes = false;

		switch($setting_id) {
			case 'menu':
				$success = $this->updateMenuSettings();
				break;
			case 'export':
				$success = $this->updateExportSettings();
				break;
			case 'project_name':
				$input = Input::get($setting_id);
				$success = Setting::set($setting_id, $input);
				break;
		}

		if($success) {
			return Redirect::to(route('settings.index'))
				->with('message', [
					'content' => 'Instellingen met succes geupdated!',
					'class' => 'success'
				]);
		} else {
			return View::make('settings.index')
				->with('message', [
					'content' => 'Er is iets misgegaan met de instelling. :(',
					'class' => 'warning'
				]);
		}
	}

}
