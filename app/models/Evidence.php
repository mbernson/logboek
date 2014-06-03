<?php

class Evidence extends Model {
	protected $softDelete = true;

	protected $fillable = ['id', 'title', 'hash', 'date_received', 'sender', 'original_message', 'encrypted_message', 'software'];

	protected $rules = [
		'title' => 'required',
		'hash' => 'required',
		'date_received' => 'required',
		'sender' => 'required',
		'original_message' => 'required',
	];

	// Relations

	public function user() {
		return $this->belongsTo('User', 'user_id');
	}

	// Dates

	public function getDates() {
		return array_merge(parent::getDates(), ['date_received']);
	}

	// Mutators

	public function setOriginalMessageAttribute($value) {
		$this->attributes['original_message'] = $value;
		$this->attributes['html_original_message'] = Markdown::string($value);
	}

	public function setEncryptedMessageAttribute($value) {
		$this->attributes['encrypted_message'] = $value;
		$this->attributes['html_encrypted_message'] = Markdown::string($value);
	}

	// Scopes

	public function scopeNewest($query) {
		return $query->orderBy('date_received');
	}
}
