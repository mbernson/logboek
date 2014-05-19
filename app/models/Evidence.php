<?php

class Evidence extends Model {
	protected $fillable = ['id', 'title', 'hash', 'date_received', 'sender', 'original_message', 'encrypted_message', 'software'];

	protected $rules = [
		'title' => 'required',
		'hash' => 'required',
		'date_received' => 'required',
		'sender' => 'required',
		'original_message' => 'required',
	];

	public function user() {
		return $this->belongsTo('User', 'user_id');
	}

	public function getDates() {
		return array_merge(parent::getDates(), ['date_received']);
	}

	public function setBodyAttribute($value) {
		$this->attributes['original_message'] = $value;
		$this->attributes['html_original_message'] = Markdown::string($value);
		$this->attributes['encrypted_message'] = $value;
		$this->attributes['html_encrypted_message'] = Markdown::string($value);
	}
}
