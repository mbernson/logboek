<?php

namespace Exports;

use File;
use View;

class HTML extends \Export {

	protected $content_type = 'text/html';
	protected $extension = 'html';

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		$this->type = 'html';
	}

}
