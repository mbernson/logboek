<?php

class ExportsController extends \BaseController {

	public function index() {
		return View::make('exports.index', [
			'exports' => Export::paginate(25)
		]);
	}

	public function create($type = 'csv') {
		switch($type) {
		case 'csv':
			return $this->exportCSV();
		case 'pdf':
			return $this->exportPDF();
		default:
			App::abort(404);
		}
	}

	private function exportCSV() {
		if(Entry::count() == 0)
			throw new Exception('No entries available');

		$export = new Exports\CSV();
		$export->user_id = Auth::user()->id;
		$export->filename = date('YmdHis').'_logboek_export.csv';
		$export->path = $export->folderPath();

		if($export->run() && $export->save()) {
			return Response::download($export->fullPath(), $export->filename, [
				'Content-type' => 'text/csv'
			]);
		} else {
			return Redirect::to(action('ExportsController@index'))
			->with('message', [
				'content' => 'Er is iets mis gegaan met exporteren.',
				'class' => 'danger'
			]);
		}
	}

	public function exportPDF() {
		$export = new Exports\PDF();
		$export->user_id = Auth::user()->id;
		$export->filename = date('YmdHis').'_logboek_export.pdf';
		$export->path = $export->folderPath();

		if($export->run() && $export->save()) {
			return Response::download($export->fullPath(), $export->filename, [
				'Content-type' => 'application/pdf'
			]);
		} else {
			return Redirect::to(action('ExportsController@index'))
			->with('message', [
				'content' => 'Er is iets mis gegaan met exporteren.',
				'class' => 'danger'
			]);
		}
	}

	public function destroy($export_id) {
		$export = Export::findOrFail($export_id);
		$export->delete();

		return Redirect::to(action('ExportsController@index'))
			->with('message', [
				'content' => 'Export verwijderd.',
				'class' => 'danger'
			]);
	}

}
