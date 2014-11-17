<?php

class Export extends Model {

	protected $table = 'exports';

	protected $logbooks = 'all';

	// Subclasses are expected to implement these properties

	protected $content_type;
	protected $extension;

	public $content;

	// Relations

	public function user() {
		return $this->belongsTo('User', 'user_id');
	}

	// Utility

	/**
	 * Return the path to the exports folder
	 */
	public function folderPath() {
		return public_path().'/downloads/';
	}

	/**
	 * Return the full path to the exported file
	 */
	public function fullPath() {
		return public_path().'/downloads/'.$this->filename;
	}

	/**
	 * Return the path to the file for downloading
	 */
	public function downloadPath() {
		return '/downloads/'.$this->filename;
	}

	public function generateFilename() {
		return date('YmdHis').'_logboek_export.'.$this->extension;
	}

	public function getContentType() {
		return $this->content_type;
	}

	protected function updateFileSize() {
		$this->filesize = filesize($this->fullPath()) / 1024; // In kilobytes
	}

	// Overrides

	public function delete() {
		unlink($this->fullPath());
		return parent::delete();
	}

	// Export functions

	protected function getView() {
		$settings = [
			'title' => Setting::get('ex_pdf_title'),
			'customer' => Setting::get('ex_pdf_customer'),
			'date' => Setting::get('ex_pdf_date'),
			'version' => Setting::get('ex_pdf_version')
		];

		return View::make('pdfs.report', [
			'project_name' => Setting::get('project_name'),
			'generated_at' => date('d-m-Y H:i'),
			'users' => static::getUsers(),
			'logbooks' => static::getLogbooks($this->logbooks),
			'attachments' => static::getAttachments($this->logbooks),
			'attachmentsAll' => Attachment::all(),
			'evidences' => Evidence::all(),
			'suspects' => Suspect::all(),
			'settings' => $settings
		]);
	}

	// Convenience methods for export data

	public function setLogbooks($val) {
		$this->logbooks = $val;
	}

	protected static function getUsers() {
		return User::with('picture')
			->where('id', '!=', 0)
			->where('username', 'not like', 'test%')
			->get();
	}

	protected static function getLogbooks($range) {
		$id = intval($range);
		if($range == 'all')
			return Logbook::all();
		elseif($id != 0)
			return [Logbook::find($id)];
		else
			return [Logbook::first()];
	}

	protected static function getAttachments($range) {
		return [];
		$id = intval($range);
		if($id != 0)
			return Logbook::find($id)
			->user
			->attachments;
		return Attachment::orderBy('id', 'asc')->get();
	}

}
