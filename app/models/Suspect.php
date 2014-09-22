<?php

class Suspect extends Model {
	protected $fillable = ['name', 'alias'];

	protected $rules = [
		'name' => 'required',
	];
}
