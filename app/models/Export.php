<?php

class Export extends Model {

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

}
