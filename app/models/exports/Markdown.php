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

	private function generateMarkdown() {
		$view = $this->getView();
		return $view->render();
	}

	public function run($save = true) {
		$text = $this->generateMarkdown();
		if($save) {
			if(!File::put($this->fullPath(), $text))
				return false;

			$this->updateFileSize();
		} else {
			$this->content = $text;
			$this->filesize = 0;
		}

		return true;
	}

}
