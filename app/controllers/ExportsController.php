<?php

class ExportsController extends \BaseController {

	public function index() {
		return View::make('exports.index', [
			'exports' => Export::paginate(25)
		]);
	}

	private static function getExportForType($type) {
		switch($type) {
		case 'csv':
			return new Exports\CSV();
		case 'pdf':
			return new Exports\PDF();
		default:
			throw new Exception("Uknown type '$type'");
		}
	}

	public function create($type = 'csv') {
		try { $export = static::getExportForType($type); }
		catch(Exception $e) { App::abort(404); }

		$export->user_id = Auth::user()->id;
		$export->filename = $export->generateFilename();
		$export->path = $export->folderPath();

		if($export->run() && $export->save()) {
			return Response::download($export->fullPath(), $export->filename, [
				'Content-type' => $export->getContentType()
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
