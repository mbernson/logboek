<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RenderMarkdownCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'render_markdown';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Re-renders markdown content.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
		$this->info('Markdown renderer running...');

		$type = $this->argument('type');
		$id = $this->option('id');

		if(!empty($id)) {
			$item = call_user_func([$type, 'find'], $this->option('id'));
			if(!$item) {
				$this->error("$type #$id not found.");
				return false;
			}
			$items = [$item];
		} else {
			$items = call_user_func([$type, 'all']);
		}

		$this->updateItems($items);
	}

	private function updateItems($items) {
		$count = 0;
		foreach($items as $item) {
			$this->info("Processing item $item->id, '$item->title'");
			$this->updateMarkdown($item);
			$count++;
		}
		$this->info("Processed $count items");
	}

	private function updateMarkdown($item) {
		$body = $item->body;
		$item->setBodyAttribute($body);
		$item->save();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return array(
			array('type', InputArgument::REQUIRED, 'The name of the model to re-render.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions() {
		return array(
			array('id', null, InputOption::VALUE_OPTIONAL, "The ID of a model to re-render.", null),
		);
	}

}
