<?php

class EvidenceController extends \BaseController {

	public function __construct() {
		parent::__construct();

		$users_options = [];
		foreach(User::all() as $user)
			$users_options[$user->id] = $user->username;

		View::share(['users_options' => $users_options]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$evidences = Evidence::newest()
			->orderBy('title')
			->paginate(self::$per_page);

		return View::make('evidences.index', ['evidences' => $evidences]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		return View::make('evidences.create', ['evidence' => new Evidence()]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$evidence = new Evidence();

		$evidence->unguard();
		$evidence->fill(Input::only(['title', 'hash', 'sender', 'original_message', 'encrypted_message', 'software']));
		$evidence->date_received = new DateTime(Input::get('date_received'));

		if($evidence->validate()) {
			$evidence->save();
		} else {
			return View::make('evidences.edit', ['evidence' => $evidence])
				->withErrors($evidence->validator());
		}

		return Redirect::to(route('evidences.index'))
			->with('message', [
				'content' => 'Bewijs met succes aangemaakt!',
				'class' => 'success'
			]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		$evidence = Evidence::findOrFail($id);
		return View::make('evidences.show', ['evidence' => $evidence]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
		$evidence = Evidence::findOrFail($id);
		return View::make('evidences.edit', ['evidence' => $evidence]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		$evidence = Evidence::findOrFail($id);

		$evidence->fill(Input::only(['title', 'hash', 'sender', 'original_message', 'encrypted_message', 'software']));
		if(Input::has('date_received'))
			$evidence->date_received = new DateTime(Input::get('date_received'));

		if($evidence->validate()) {
			$evidence->save();
		} else {
			return View::make('evidences.edit', ['evidence' => $evidence])
				->withErrors($evidence->validator());
		}

		return Redirect::to(route('evidences.index'))
			->with('message', [
				'content' => 'Bewijs met succes geupdated!',
				'class' => 'success'
			]);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		$evidence = Evidence::findOrFail($id);
		$evidence->delete();

		return Redirect::to(route('evidences.index'))
			->with('message', [
				'content' => 'Bewijs met succes verwijderd!',
				'class' => 'success'
			]);
	}


}
