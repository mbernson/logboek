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

	public function run($save = true) {
		$view = View::make('pdfs.report', [
			'title' => 'IPFIT1 groep 2',
			'logbooks' => Logbook::all(),
			'generated_at' => date('d-m-Y H:i'),
		]);

		$pdf = DOMPDF::load($view->render(), 'A4', 'portrait')->output();
		if($save) {
			if(!File::put($this->fullPath(), $pdf))
				return false;

			$this->updateFileSize();
		} else {
			$this->pdf = $pdf;
			$this->filesize = 0;
		}

		return true;
	}

}
