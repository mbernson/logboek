<?php

namespace Exports;

use Entry;
use User;
use Logbook;

use File;
use View;

class Markdown extends \Export {

	protected $content_type = 'text/plain';
	protected $extension = 'md';

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		$this->type = 'markdown';
	}

	private function getView() {
		$users = User::where('id', '!=', 0);
		return View::make('markdown.report', [
			'title' => 'IPFIT1 groep 2',
			'users' => $users,
			'logbooks' => Logbook::all(),
			'generated_at' => date('d-m-Y H:i'),
		]);
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
