<?php

class Task extends Model {
    protected $fillable = ['name', 'user_id', 'desc', 'deadline'];

    public function user() {
	return $this->belongsTo('User', 'user_id');
    }
}
