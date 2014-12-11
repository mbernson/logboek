<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;
class EntriesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$entries = Entry::inOverview()
			->orderBy('finished_at', 'desc')
			->orderBy('started_at', 'desc')
			->paginate(10);

		return View::make('entries.index', [
			'title' => 'Recente entries',
			'entries' => $entries,
		]);
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
			'entry' => $entry,
			'evidences' => Evidence::all(),
			'choices' => $this->getEvidenceChoices()
		]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($logbook_id) {
		$logbook = Logbook::findOrFail($logbook_id);

		if($logbook->user_id == (Auth::user()->id) OR $logbook->user_id == 0) {
			$entry = new Entry(Input::only('title', 'body', 'started_at', 'finished_at', 'evidence_id', 'who', 'what', 'where', 'which', 'way', 'when', 'why'));

			$entry->logbook_id = $logbook->id;

			if($entry->validate()){
				$entry->save();
			} else {
				return View::make('entries.create', ['entry' => $entry, 'logbook' => $logbook])
					->withErrors($entry->validator());
			}
			return Redirect::to(route('logbooks.show', [$logbook->id]))
				->with('message', [
					'content' => 'Entry met succes aangemaakt!',
					'class' => 'success'
				]);
		} else {
			return Redirect::to(route('logbooks.show', [$logbook->id]))
				->with('message', [
					'content' => 'Geen rechten om entry weg te schrijven!',
					'class' => 'danger'
				]);
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($logbook_id, $entry_id) {
		try{
				$logbook = Logbook::findOrFail($logbook_id);
				$entry = Entry::findOrFail($entry_id);
				return View::make('entries.show', [
					'logbook' => $logbook,
					'entry' => $entry
				]);
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('logbooks.index'))
				->with('message', [
					'content' => 'Entry niet gevonden!',
					'class' => 'danger'
				]);
		}
	}

	private function getEvidenceChoices() {
		$evidences = Evidence::select('id', 'title')->get();

		$choices = [
			0 => 'Selecteer bewijs'
		];
		foreach($evidences as $evidence) {
			$choices[$evidence->id] = $evidence->title;
		}

		return $choices;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($logbook_id, $entry_id) {
		try{
				$logbook = Logbook::findOrFail($logbook_id);
				$entry = Entry::findOrFail($entry_id);

				return View::make('entries.edit', [
					'logbook' => $logbook,
					'entry' => $entry,
					'evidences' => Evidence::all(),
					'choices' => $this->getEvidenceChoices()
				]);
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('logbooks.index'))
				->with('message', [
					'content' => 'Entry niet gevonden!',
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
	public function update($logbook_id, $entry_id) {
		$logbook = Logbook::findOrFail($logbook_id);

		if($logbook->user_id == (Auth::user()->id) || $logbook->user_id == 0) {

			$entry = Entry::findOrFail($entry_id);

			$entry->fill(Input::only('title', 'body', 'started_at', 'finished_at', 'evidence_id', 'who', 'what', 'where', 'which', 'way', 'when', 'why'));

			if($entry->validate())
				$entry->save();
			else
				return View::make('entries.edit', ['entry' => $entry, 'logbook' => $logbook])
				->withErrors($entry->validator());

			return Redirect::to(route('logbooks.show', [$logbook->id]))
				->with('message', [
					'content' => 'Entry met succes geupdated!',
					'class' => 'success'
				]);
		} else {
			return Redirect::to(route('logbooks.show', [$logbook->id]))
				->with('message', [
					'content' => 'Geen rechten om entry te updaten!',
					'class' => 'danger'
				]);

		}
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
				'content' => 'Entry met succes verwijderd!',
				'class' => 'success'
			]);
	}

}
