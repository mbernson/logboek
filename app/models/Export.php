<?php

class Export extends Model {

	protected $table = 'exports';

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

	// Convenience methods for export data

	protected static function getUsers() {
		return User::with('picture')
			->where('id', '!=', 0)
			->where('username', 'not like', 'test%')
			->get();
	}

	protected static function getLogbooks() {
		return [Logbook::first()];
	}

	protected static function getAttachments() {
		return Attachment::orderBy('id', 'asc')->get();
	}

}
