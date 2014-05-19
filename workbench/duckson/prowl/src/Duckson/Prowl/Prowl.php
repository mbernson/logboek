<?php

namespace Duckson\Prowl;

use \Prowl\Connector;
use \Prowl\Message;

use \Config;
use \Exception;
use \Log;

class Prowl {
	protected $connector;

	public function __construct() {
		$this->connector = new Connector();
		// The library demands to set a filter
		$this->connector->setFilter(new \Prowl\Security\PassthroughFilterImpl());
		$this->connector->setIsPostRequest(true);
	}

	public function send($event, $description = '', $application = 'Laravel', $priority = 0) {
		$api_key = Config::get('app.prowl_api_key');
		var_dump($api_key);
		if(empty($api_key)) {
			throw new Exception('Invalid Prowl API key');
		}

		$message = new Message();
		$message->addApiKey($api_key);
		$message->setPriority($priority);
		$message->setEvent((string) $event);

		if(!empty($description))
			$message->setDescription((string) $description);

		if(!empty($application))
			$message->setApplication((string) $application);

		$response = $this->connector->push($message);

		if($response->isError()) {
			Log::error(new Exception($response->getErrorAsString()));
		} else {
			Log::info("Prowl message sent. You have ".$response->getRemaining()." messages left.");
			Log::info("Your counter will be resetted on " . date('Y-m-d H:i:s', $response->getResetDate()));
		}
	}
}
