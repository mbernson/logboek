<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ExportCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'export';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Export logbook(s) to a file.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	private static function getExportForType($type) {
		switch($type) {
		case 'csv':
			return new Exports\CSV();
		case 'pdf':
			return new Exports\PDF();
		case 'markdown':
			return new Exports\Markdown();
		default:
			throw new Exception("Uknown type '$type'");
		}
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$type = $this->option('type');;
		$export = static::getExportForType($type);

		$export->user_id = User::first();
		$export->filename = $export->generateFilename();
		$export->path = $export->folderPath();
		$logbooks = $this->option('logbooks');
		if(empty($logbooks)) $logbooks = 'all';
		$export->setLogbooks($logbooks);

		$save = true;

		if($export->run($save)) {
			$export->save();
			$this->info('Export opgeslagen in '.$export->filename);
		} else {
			$this->error('Er is iets mis gegaan met exporteren.');
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('type', null, InputOption::VALUE_REQUIRED, 'The type of file to create.', null),
			array('logbooks', null, InputOption::VALUE_REQUIRED, 'The logbook range to process.', null),
		);
	}

}
