<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Task extends Model {
	use SoftDeletingTrait;

	protected $fillable = ['name', 'user_id', 'description', 'status', 'deadline'];

	protected $rules = [
		'name' => 'required',
		'user_id' => 'required',
		'deadline' => 'required',
	];

	public function isOpen() {
		return $this->status == 0;
	}

	public function isClosed() {
		return $this->status == 1;
	}

	// Relations

	public function user() {
		return $this->belongsTo('User', 'user_id');
	}

	// Dates

	public function getDates() {
		return array_merge(parent::getDates(), ['deadline']);
	}

	// Mutators

	public function setBodyAttribute($value) {
		$this->attributes['description'] = $value;
		$this->attributes['html_description'] = Markdown::string($value);
	}

	// Scopes

	public function scopeNewest($query) {
		return $query->orderBy('deadline', 'desc');
	}

	public function scopeOldest($query) {
		return $query->orderBy('deadline', 'asc');
	}

	public function scopeOpen($query) {
		return $query->where('status', 0);
	}

	public function scopeClosed($query) {
		return $query->where('status', 1);
	}
}
