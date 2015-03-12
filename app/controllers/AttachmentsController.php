<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;
class AttachmentsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$attachments = Attachment::orderBy('id', 'desc')
										->paginate(25);

		$uploads = DB::table('uploads')->select('name', 'owner', 'md5', 'sha1')
								->where('owner', Auth::user()->username)
								->orderBy('updated_at', 'desc')
								->paginate(25);

		$alluploads = DB::table('uploads')->select('name', 'owner', 'md5', 'sha1')
								->orderBy('updated_at', 'desc')
								->paginate(25);

		$attachmentsCount = count($attachments);
		$uploadsCount = count($uploads);
		$alluploadsCount = count($alluploads);

		return View::make('attachments.index', [
			'attachments' => $attachments,
			'uploads' => $uploads,
			'alluploads' => $alluploads,
			'attachmentsCount' => $attachmentsCount,
			'uploadsCount' => $uploadsCount,
			'alluploadsCount' => $alluploadsCount
		]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		return View::make('attachments.create', ['attachment' => new Attachment()]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$att = new Attachment();
		$att->unguard();
		$att->fill(Input::only('title', 'description',
			'hash', 'hash_algorithm', 'public'));

		if(!Input::hasFile('upload')) {
			Session::flash('message', [
				'content' => 'Geen bestand ontvangen.',
				'class' => 'danger'
			]);
			return View::make('attachments.create', ['attachment' => $att]);
		}
		if(!Input::file('upload')->isValid()) {
			Session::flash('message', [
				'content' => 'Ongeldig bestand ontvangen.',
				'class' => 'danger'
			]);
			return View::make('attachments.create', ['attachment' => $att]);
		}

		$file = Input::file('upload');
		$name = $file->getClientOriginalName();
		$extension = $file->getClientOriginalExtension();

		$att->user_id = Auth::user()->id;
		$att->filename = $name;
		$att->extension = $extension;

		// We need to validate the attributes before moving the attachment into place
		if(!$att->validate()) {
			return View::make('attachments.create', ['attachment' => $att])
				->withErrors($att->validator());
		}

		$file->move($att->folderPath(), $att->filename);
		$att->path = $att->folderPath();
		$att->filesize = filesize($att->fullPath());

		if(in_array($att->extension, Attachment::$image_extensions))
			$att->type = 'Image';

		$att->save();
		return Redirect::to(route('attachments.show', [$att->id]))
			->with('message', [
				'content' => 'Bestand met succes geupload!',
				'class' => 'success'
			]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $attachment_id
	 * @return Response
	 */
	public function show($attachment_id) {
		try{
			return View::make('attachments.show', [
				'attachment' => Attachment::findOrFail($attachment_id)
			]);
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('attachments.index'))
				->with('message', [
					'content' => 'Bestand niet gevonden!',
					'class' => 'danger'
				]);
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $attachment_id
	 * @return Response
	 */
	public function edit($attachment_id) {
		try{
			return View::make('attachments.edit', [
				'attachment' => Attachment::findOrFail($attachment_id)
			]);
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('attachments.index'))
				->with('message', [
					'content' => 'Bestand niet gevonden!',
					'class' => 'danger'
				]);
		}
	}

	public function upload(){
		try{
			$file = Input::file('file');
			$extension = File::extension($file->getClientOriginalName());
			$directory = 'uploads/';

			$date = date('Ymdhis');
			$rand = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 5);
			$filename = $date .'_'. $rand . '.' . $extension;

			$upload_success = Input::file('file')->move($directory, $filename);
			$timestamp = date('Y-m-d H:i:s');

			DB::table('uploads')->insert(
				array('name' => $filename,
							'owner' => Auth::user()->username,
							'md5' => md5_file('uploads/'. $filename),
							'sha1' => sha1_file('uploads/'. $filename),
							'created_at' => $timestamp,
							'updated_at' => $timestamp,
				));
		} catch(ModelNotFoundException $e) {
			return Redirect::to(route('attachments.index'))
			->with('message', [
				'content' => 'Bestand niet gevonden!',
				'class' => 'danger'
				]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $attachment_id
	 * @return Response
	 */
	public function update($attachment_id) {
		$attachment = Attachment::findOrFail($attachment_id);

			if($attachment->user_id != (Auth::user()->id)) {
				return Redirect::to(route('attachments.show', [$attachment->id]))
					->with('message', [
						'content' => 'Geen rechten om bestand te updaten!',
						'class' => 'danger'
					]);
			}

		$attachment->fill(Input::only('title', 'description',
			'hash', 'hash_algorithm'));

		if($attachment->validate()) {
			$attachment->save();
		} else {
			return View::make('attachments.edit', ['attachment' => $attachment])
				->withErrors($attachment->validator());
		}
		return Redirect::to(route('attachments.index'))
			->with('message', [
				'content' => 'Bestand met succes geupdated!',
				'class' => 'success'
			]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $attachment_id
	 * @return Response
	 */
	public function destroy($attachment_id) {
		$attachment = Attachment::findOrFail($attachment_id);
		$attachment->delete();
		return Redirect::to(route('attachments.index'))
			->with('message', [
				'content' => 'Bestand met succes verwijderd!',
				'class' => 'success'
			]);

	}


	/**
	 * Download the specified resource.
	 *
	 * Attachment downloads pass through this method for security reasons.
	 *
	 * @param  int  $attachment_id
	 * @return Response
	 */
	public function download($attachment_id) {
		$attachment = Attachment::findOrFail($attachment_id);
		return Response::download($attachment->fullPath(), $attachment->escapedFilename());
	}


}
