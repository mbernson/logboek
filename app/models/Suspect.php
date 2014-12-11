<?php

class Suspect extends Model {
	protected $fillable = ['name', 'alias', 'street', 'city', 'email', 'phone'];

	protected $rules = [
		'name' => 'required',
	];
}
