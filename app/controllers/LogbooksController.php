<?php

class LogbooksController extends \BaseController {

	public function __construct() {
		parent::__construct();

		$users = User::all();
		$users_options = [0 => 'Iedereen'];
		foreach($users as $user)
			$users_options[$user->id] = $user->username;

		View::share(['users_options' => $users_options]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		return View::make('logbooks.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		return View::make('logbooks.create', [
			'logbook' => new Logbook()
		]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$logbook = new Logbook();
		$logbook->unguard();
		$logbook->fill(Input::only('title', 'user_id', 'in_overview'));

		if($logbook->validate())
			$logbook->save();
		else
			return View::make('logbooks.create', ['logbook' => $logbook])
				->withErrors($logbook->validator());

		return Redirect::to(route('logbooks.index'));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $logbook_id
	 * @return Response
	 */
	public function show($logbook_id) {
		$logbook = Logbook::findOrFail($logbook_id);
		$entries = Entry::where('logbook_id', $logbook_id)
			->orderBy('finished_at', 'desc')
			->orderBy('started_at', 'desc')
			->paginate(10);

		return View::make('logbooks.show', array(
			'logbook' => $logbook,
			'entries' => $entries
		));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $logbook_id
	 * @return Response
	 */
	public function edit($logbook_id) {
		$logbook = Logbook::findOrFail($logbook_id);
		return View::make('logbooks.edit', ['logbook' => $logbook]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $logbook_id
	 * @return Response
	 */
	public function update($logbook_id) {
		$logbook = Logbook::findOrFail($logbook_id);
		$logbook->unguard();

		if($logbook->validate())
			$logbook->save();
		else
			return View::make('logbooks.edit', ['logbook' => $logbook])
				->withErrors($logbook->validator());

		return Redirect::to(route('logbooks.index'));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $logbook_id
	 * @return Response
	 */
	public function destroy($logbook_id) {
		//
	}


}
