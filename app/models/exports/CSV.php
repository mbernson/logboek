<?php

namespace Exports;

use Keboola\Csv\CsvFile;
use Entry;

class CSV extends \Export {

	protected $content_type = 'text/csv';
	protected $extension = 'csv';

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		$this->type = 'csv';
	}

	public function run() {
		$csv = new CsvFile($this->fullPath());

		$entries = Entry::all();
		$header = array_keys((new Entry())->toArray());

		$csv->writeRow($header);
		foreach($entries as $entry) {
			$row = array_values($entry->toArray());
			$csv->writeRow($row);
		}

		$this->updateFileSize();

		return true;
	}

}

