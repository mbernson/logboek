<?php

class Entry extends Model {
    protected $table = 'entries';

    protected $fillable = ['title', 'body', 'started_at', 'finished_at'];

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

    public function save(array $options = []) {
	    if(empty($this->finished_at)) {
		    $this->finished_at = new DateTime();
	    }

	    return parent::save($options);
    }
}
