<?php

class BaseController extends Controller {

	protected $layout = 'layouts.application';

	protected static $per_page = 15;

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout() {
		if ( ! is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	}

	public function __construct() {
		View::share('logbooks', Logbook::all());
		View::share('tasks', Task::where('status', false)
			->orderBy('deadline', 'asc')
			->take(7)->get()); // Oudste deadlines bovenaan
	}
}
