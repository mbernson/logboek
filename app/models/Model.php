<?php

abstract class Model extends Eloquent {

	public function isNew() {
		return empty($this->id);
	}

	// Validation rules
	protected $rules = [];
	protected $edit_rules = [];

	protected function rules() {
		if(!$this->isNew() && !empty($this->edit_rules))
			return $this->edit_rules;
		return $this->rules;
	}

	public function validate() {
		$this->validator = Validator::make($this->attributes, $this->rules());

		return $this->validator->passes();
	}

	protected $validator;
	public function validator() {
		return $this->validator;
	}
}
