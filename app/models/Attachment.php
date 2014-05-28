<?php

class Attachment extends Model {
	protected $table = 'attachments';

	protected $softDelete = true;

	protected $rules = [
		'hash' => 'required',
		'hash_algorithm' => 'required',
		'filename' => 'required',
		'extension' => 'required',
	];

	protected $fillable = [
		'title', 'description',
		'hash', 'hash_algorithm'
	];

	public function calculatedHash() {
		$hash = '';
		switch($this->hash_algorithm) {
		case 'md5':
			$hash = md5_file($this->fullPath());
			break;
		case 'sha1':
			$hash = sha1_file($this->fullPath());
			break;
		default:
			Log::error("Unsupported hash $this->hash_algorithm at attachment #$this->id");

			return false;
		}
		return $hash;
	}

	public function validateHash() {
		return $this->calculatedHash() === $this->hash;
	}

	// Overrides

	public function delete() {
		unlink($this->fullPath());
		return parent::delete();
	}

	// Relations

	public function user() {
		return $this->belongsTo('User', 'user_id');
	}

	public function entries() {
		return $this->morphedByMany('Entry', 'attachable');
	}

	// Path functions

	const BASE_PATH = '/uploads/';

	/**
	 * Return the path to the file's folder
	 */
	public function folderPath() {
		if(empty($this->path))
			return storage_path().self::BASE_PATH;
		else
			return $this->path;
	}

	/**
	 * Return the full path to the file
	 */
	public function fullPath() {
		if(empty($this->path))
			return storage_path().self::BASE_PATH.$this->filename;
		else
			return $this->path.$this->filename;
	}

	/**
	 * Return the path to the file for downloading
	 */
	public function downloadPath() {
		return action('AttachmentsController@download', [$this->id]);
	}

	public function	escapedFilename() {
		return $this->filename;
	}

	// Allowed algorithms and extensions

	public static $image_extensions = [
		'jpg', 'jpeg', 'png', 'gif'
	];

	public static $hash_algorithms = [
		'sha1', 'md5'
	];

	public static function hashAlgorithmChoices() {
		$result = [];
		foreach(static::$hash_algorithms as $algo)
			$result[$algo] = $algo;
		return $result;
	}
}
