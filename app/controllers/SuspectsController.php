<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;
class SuspectsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		return Redirect::to('/settings');
	}

	public function show() {
		return Redirect::to('/settings');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		return View::make('suspects.create', [
			'suspect' => new Suspect()
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$suspect = new Suspect(Input::only('name', 'alias', 'street', 'city', 'email', 'phone'));

		if($suspect->validate()) {
			$suspect->save();
		} else {
			return View::make('suspects.create', ['suspect' => $suspect])
				->withErrors($suspect->validator());
		}

		return Redirect::to(route('settings.index'))
			->with('message', [
				'content' => 'Verdachte met succes aangemaakt!',
				'class' => 'success'
			]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($suspect_id) {
		try{
			$suspect = Suspect::findOrFail($suspect_id);
			return View::make('suspects.edit', ['suspect' => $suspect]);
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('settings.index'))
				->with('message', [
					'content' => 'Verdachte niet gevonden!',
					'class' => 'danger'
				]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($suspect_id) {
		$suspect = Suspect::findOrFail($suspect_id);

		$suspect->fill(Input::only('name', 'alias', 'street', 'city', 'email', 'phone'));

		if($suspect->validate()) {
			$suspect->save();
		} else {
			return View::make('suspects.edit', ['suspect' => $suspect])
				->withErrors($suspect->validator());
		}

		return Redirect::to(route('settings.index'))
			->with('message', [
				'content' => 'Verdachte met succes geupdated!',
				'class' => 'success'
			]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($suspect_id) {
		$suspect = Suspect::findOrFail($suspect_id);
		$suspect->delete();

		return Redirect::to(route('settings.index'))
			->with('message', [
				'content' => 'Verdachte met succes verwijderd!',
				'class' => 'success'
			]);
	}

}
