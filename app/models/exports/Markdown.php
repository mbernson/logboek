<?php

namespace Exports;

use File;
use View;

class Markdown extends \Export {

	protected $content_type = 'text/plain';
	protected $extension = 'md';

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		$this->type = 'markdown';
	}

}
