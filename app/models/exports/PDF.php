<?php

namespace Exports;

use Entry;
use Logbook;

use File;
use View;
use PDF as DOMPDF;

class PDF extends \Export {

	protected $content_type = 'application/pdf';
	protected $extension = 'pdf';

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		$this->type = 'pdf';
	}

	public $pdf;

	public function run() {
		$view = View::make('pdfs.report', [
			'title' => 'IPFIT1 groep 2',
			'logbooks' => Logbook::all(),
			'chapters' => [], 'chapter' => 0,
			'generated_at' => date('d-m-Y H:i'),
		]);

		$pdf = DOMPDF::load($view->render(), 'A4', 'portrait')->output();
		$this->pdf = $pdf;

		File::put($this->fullPath(), $pdf);

		$this->updateFileSize();

		return true;
	}

}
