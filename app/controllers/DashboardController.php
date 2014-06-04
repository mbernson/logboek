<?php

class DashboardController extends \BaseController {

	public function intro() {
		return View::make('intro');
	}

	public function cipher_tool() {
		return View::make('cipher');
	}

}
