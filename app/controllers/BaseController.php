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
		View::share('logbooks', Logbook::all()
			->take(10));

		if(Auth::check()) {
			View::share('user_logbook', Logbook::where('user_id', Auth::user()->id)
				->first());
		}

		View::share('recent_tasks', Task::open()->newest()
			// https://www.youtube.com/watch?v=o2In5a9LDNg
			->take(5)
			->get());
	}
}
