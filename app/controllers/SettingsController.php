<?php

class SettingsController extends \BaseController {

	public function __construct() {
		parent::__construct();

		$users = User::orderBy('username')
			->paginate(self::$per_page);

		$this->features = [
			'entries', 'logbooks', 'tasks',
			'attachments', 'evidences', 'exports',
			'cipher'
		];

		View::share('users', $users);
		View::share('settings', Setting::all());
		View::share('suspects', Suspect::all());
		View::share('features', $this->features);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		return View::make('settings.index');
	}

	public function update($setting_id) {
		if($setting_id == 'menu') {
			$features = [];
			$input = Input::only($this->features);

			foreach($input as $feature => $enabled)
				if($enabled) $features[] = $feature;

			$input = join(';', $features);
		} else {
			$input = Input::get($setting_id.'_value');
		}

		if(Setting::set($setting_id, $input)) {
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
