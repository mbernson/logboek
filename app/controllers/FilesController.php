<?php

class FilesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		return View::make('files.index', [
			'files' => File::orderBy('created_at', 'asc')
				->orderBy('updated_at', 'asc')
				->paginate(25)
		]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		return View::make('files.create', ['file' => new File()]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$f = new File();
		$f->unguard();
		$f->fill(Input::only('title', 'description',
			'hash', 'hash_algorithm'));

		if(!Input::hasFile('upload')) {
			Session::flash('message', [
				'content' => 'Geen bestand ontvangen.',
				'class' => 'danger'
			]);
			return View::make('files.create', ['file' => $f]);
		}
		if(!Input::file('upload')->isValid()) {
			Session::flash('message', [
				'content' => 'Ongeldig bestand ontvangen.',
				'class' => 'danger'
			]);
			return View::make('files.create', ['file' => $f]);
		}

		$file = Input::file('upload');
		$name = $file->getClientOriginalName();
		$extension = $file->getClientOriginalExtension();

		$f->user_id = Auth::user()->id;
		$f->filename = $name;
		$f->extension = $extension;

		// We need to validate the attributes before moving the file into place
		if(!$f->validate()) {
			return View::make('files.create', ['file' => $f])
				->withErrors($f->validator());
		}

		$file->move($f->folderPath(), $f->filename);
		$f->path = $f->folderPath();
		$f->filesize = filesize($f->fullPath());

		if(in_array($f->extension, File::$image_extensions))
			$f->type = 'Image';

		$f->save();
		return Redirect::to(route('files.show', [$f->id]))
			->with('message', [
				'content' => 'Bestand met succes geupload!',
				'class' => 'success'
			]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $file_id
	 * @return Response
	 */
	public function show($file_id) {
		return View::make('files.show', [
			'file' => File::findOrFail($file_id)
		]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $file_id
	 * @return Response
	 */
	public function edit($file_id) {
		return View::make('files.edit', [
			'file' => File::findOrFail($file_id)
		]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $file_id
	 * @return Response
	 */
	public function update($file_id) {
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $file_id
	 * @return Response
	 */
	public function destroy($file_id) {
		$file = File::findOrFail($file_id);
		$file->delete();
		return Redirect::to(route('files.index'))
			->with('message', [
				'content' => 'Bestand verwijderd!',
				'class' => 'danger'
			]);

	}


	/**
	 * Download the specified resource.
	 *
	 * File downloads pass through this method for security reasons.
	 *
	 * @param  int  $file_id
	 * @return Response
	 */
	public function download($file_id) {
		$file = File::findOrFail($file_id);
		return Response::download($file->fullPath(), $file->escapedFilename());
	}


}
