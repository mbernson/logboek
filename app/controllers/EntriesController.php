<?php

class EntriesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($logbook_id) {
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($logbook_id) {
		$logbook = Logbook::findOrFail($logbook_id);
		$entry = new Entry();
		return View::make('entries.create', [
			'logbook' => $logbook,
			'entry' => $entry
		]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($logbook_id) {
		$logbook = Logbook::findOrFail($logbook_id);

		$entry = new Entry(Input::only('title', 'body'));

		// Run all date attributes through strtotime
		foreach($entry->getDates() as $date_attr) {
			if(Input::has($date_attr))
				$entry->$date_attr = new DateTime(
					Input::get($date_attr)
				);
		}

		$entry->logbook_id = $logbook->id;

		$entry->save();
		return Redirect::to(route('logbooks.show', [$logbook->id]))
			->with('message', [
				'content' => 'Entry toegevoegd',
				'class' => 'success'
			]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($logbook_id, $entry_id) {
		$logbook = Logbook::findOrFail($logbook_id);
		$entry = Entry::findOrFail($entry_id);
		return View::make('entries.show', [
			'logbook' => $logbook,
			'entry' => $entry
		]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($logbook_id, $entry_id) {
		$logbook = Logbook::findOrFail($logbook_id);
		$entry = Entry::findOrFail($entry_id);
		return View::make('entries.edit', [
			'logbook' => $logbook,
			'entry' => $entry
		]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($logbook_id, $entry_id) {
		$logbook = Logbook::findOrFail($logbook_id);
		$entry = Entry::findOrFail($entry_id);

		$entry->fill(Input::except('_token'));

		$entry->save();
		return Redirect::to(route('logbooks.show', [$logbook->id]))
			->with('message', [
				'content' => 'Entry bijgewerkt',
				'class' => 'success'
			]);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($logbook_id, $entry_id) {
		$entry = Entry::findOrFail($entry_id);

		$entry->delete();
		return Redirect::to(route('logbooks.show', [$logbook_id]))
			->with('message', [
				'content' => 'Entry verwijderd',
				'class' => 'danger'
			]);
	}


}
