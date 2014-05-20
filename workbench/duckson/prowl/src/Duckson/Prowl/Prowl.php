<?php

namespace Duckson\Prowl;

use Prowl\Connector;
use Prowl\Message;
use Prowl\Security\PassthroughFilterImpl;

use Config;
use Exception;
use Log;

class Prowl {
	protected $connector;

	public function __construct() {
		$this->connector = new Connector();
		// The library demands to set a filter
		$this->connector->setFilter(new PassthroughFilterImpl());
		$this->connector->setIsPostRequest(true);
	}

	protected $api_key;
	public function enabled() {
		return Config::get('prowl::enabled') == true;
	}

	public function send($event, $description = '', $application = 'Laravel', $priority = 0) {
		if(!$this->enabled())
			return false;

		if(!isset($this->api_key))
			$this->api_key = Config::get('prowl::api_key');

		if(empty($this->api_key))
			throw new Exception('Invalid Prowl API key');

		$message = new Message();
		$message->addApiKey($this->api_key);
		$message->setPriority($priority);
		$message->setEvent((string) $event);

		if(!empty($description))
			$message->setDescription((string) $description);

		if(!empty($application))
			$message->setApplication((string) $application);

		$response = $this->connector->push($message);

		if($response->isError()) {
			Log::error(new Exception($response->getErrorAsString()));
			return false;
		} else {
			Log::info("Prowl message sent. You have ".$response->getRemaining()." messages left.");
			Log::info("Your counter will be resetted on " . date('Y-m-d H:i:s', $response->getResetDate()));
			return true;
		}
	}
}
