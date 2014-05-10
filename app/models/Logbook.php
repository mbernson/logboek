<?php

class Logbook extends Eloquent {
    protected $table = 'logbooks';

    public function entries() {
	    return $this->hasMany('Entry', 'logbook_id');
    }

    public function user() {
	    return $this->belongsTo('User', 'user_id');
    }

    public function owner() {
	    return $this->user();
    }
}
