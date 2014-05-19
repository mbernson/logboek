<?php

use Carbon\Carbon;

class Entry extends Model {
	protected $table = 'entries';

	protected $fillable = ['title', 'body', 'started_at', 'finished_at'];

	protected $rules = [
		'title' => 'required',
		'started_at' => 'required',
	];

	public function __construct(array $attributes = array()) {
		$this->started_at = new DateTime();
		parent::__construct($attributes);
	}

	public $timestamps = false;
	public function getDates() {
		return ['started_at', 'finished_at'];
	}

	public function logbook() {
		return $this->belongsTo('Logbook', 'logbook_id');
	}

	public function setBodyAttribute($value) {
		$this->attributes['body'] = $value;
		$this->attributes['html_body'] = Markdown::string($value);
	}

	private function setDateTimeAttribute($attr, $value) {
		if(empty($value)) return false;

		if(is_string($value)) {
			try {
				$timestamp = Carbon::createFromTimestamp(strtotime($value))
					->format($this->getDateFormat());
			} catch(Exception $e) { }
		} elseif(is_object($value)) {
			$timestamp = $this->fromDateTime($value);
		} else {
			$timestamp = $value;
		}

		$this->attributes[$attr] = $timestamp;
	}

	public function setStartedAtAttribute($value) {
		$this->setDateTimeAttribute('started_at', $value);
	}
	public function setFinishedAtAttribute($value) {
		$this->setDateTimeAttribute('finished_at', $value);
	}

	public function save(array $options = []) {
		if(empty($this->finished_at))
			$this->finished_at = new DateTime();

		return parent::save($options);
	}
}
