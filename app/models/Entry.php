<?php

use Carbon\Carbon;

class Entry extends Model {
	protected $table = 'entries';

	protected $softDelete = true;

	protected $fillable = ['title', 'body', 'started_at', 'finished_at', 'evidence_id', 'who', 'what', 'where', 'which', 'way', 'when', 'why'];

	protected $rules = [
		'title' => 'required',
		'started_at' => 'required',
	];

	public function __construct(array $attributes = array()) {
		$this->started_at = new DateTime();
		parent::__construct($attributes);
	}

	// Dates

	public $timestamps = false;
	public function getDates() {
		return ['started_at', 'finished_at'];
	}

	// Relations

	public function logbook() {
		return $this->belongsTo('Logbook', 'logbook_id');
	}

	// Mutators

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

	// Scopes

	/**
	 * Join with logbooks to select only
	 * the entries that should be shown in overviews.
	 */
	public function scopeInOverview($query) {
		return $query->join('logbooks', 'entries.logbook_id', '=', 'logbooks.id')
			->select(['entries.*', 'logbooks.in_overview'])
			->where('logbooks.in_overview', '=', '1');
	}

	// Overrides

	public function save(array $options = []) {
		if(empty($this->finished_at))
			$this->finished_at = new DateTime();

		return parent::save($options);
	}

	public function getEvidence($evidence_id) {
		 $evidence = Evidence::findOrFail($evidence_id);
		 return $evidence;
	}

	public function get7Ws() {
		$results = [];
		foreach($this->attributes as $key => $value) {
			if(substr($key, 0, 1) == 'w')
				$results[$key] = $value;
		}
		return $results;
	}	

	public function hasWs() {
		foreach($this->attributes as $key => $value) {
			if(substr($key, 0, 1) == 'w' && !empty($value))
				return true;
		}
		return false;
	}

}
