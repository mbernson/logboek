<?php

namespace Duckson\Prowl;

use Illuminate\Support\ServiceProvider;

class ProwlServiceProvider extends ServiceProvider {

	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		/* $this->package('duckson/prowl'); */
		$this->app['prowl'] = $this->app->share(function($app) {
			return new Prowl();
		});
	}

	public function boot() {
		$this->package('duckson/prowl');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return array('prowl');
	}

}
