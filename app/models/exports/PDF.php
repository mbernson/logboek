<?php

namespace Exports;

use Entry;
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

	public function run() {
		$view = View::make('pdfs.report', [
			'generated_at' => date('d-m-Y H:i')
		]);

		$pdf = DOMPDF::load($view->render(), 'A4', 'portrait')->output();

		File::put($this->fullPath(), $pdf);

		$this->updateFileSize();

		return true;
	}

}
