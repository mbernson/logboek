<?php

class Task extends Model {
    protected $fillable = ['name', 'user_id', 'description', 'status', 'deadline'];

    protected $rules = [
            'name' => 'required',
            'user_id' => 'required',
	    'deadline' => 'required',
    ];

    public function user() {
	return $this->belongsTo('User', 'user_id');
    }

    public function getDates() {
	    return array_merge(parent::getDates(), ['deadline']);
    }

    public function setBodyAttribute($value) {
            $this->attributes['description'] = $value;
            $this->attributes['html_description'] = Markdown::string($value);
    }
}
