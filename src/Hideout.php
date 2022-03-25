<?php

declare(strict_types = 1);

/**
 * Hideout SDK
 * PHP SDK for Vecode Hideout
 * @package   Hideout
 * @author    biohzrdmx <github.com/biohzrdmx>
 * @license   MIT
 * @copyright Copyright (c) 2021 Vecode. All rights reserved
 */

namespace Hideout;

use Curly\Curly;

use Hideout\HideoutException;

class Hideout {

	/**
	 * Server location
	 * @var string
	 */
	protected $server = '';

	/**
	 * Client token
	 * @var string
	 */
	protected $token = '';

	/**
	 * Constructor
	 * @param string $server Server location
	 * @param string $token  Client token
	 */
	function __construct(string $server = '', string $token = '') {
		$this->server = $server;
		$this->token = $token;
	}

	/**
	 * Return a new instance
	 * @return Hideout
	 */
	static function newInstance(): Hideout {
		$new = new self();
		return $new;
	}

	/**
	 * Set server location
	 * @param string $server Server location
	 */
	public function setServer(string $server) {
		$this->server = $server;
		return $this;
	}

	/**
	 * Set client token
	 * @param string $token Client token
	 */
	public function setToken(string $token) {
		$this->token = $token;
		return $this;
	}

	/**
	 * Generate a new key
	 * @return mixed
	 */
	public function generate() {
		$ret = false;
		$url = sprintf('%s/%s', rtrim($this->server, '/'), 'api/generate');
		$headers = [
			'Authorization' => sprintf('Bearer %s', $this->token)
		];
		$curly = Curly::newInstance()
			->setMethod('GET')
			->setHeaders($headers)
			->setURL($url)
			->execute();
		$response = $curly->getResponse();
		if ($response) {
			$body = $response->getBody();
			if ($response->getStatus() == 200) {
				if ($body->result == 'success') {
					$ret = base64_decode($body->data->key);
				} else {
					throw new HideoutException( sprintf( "API error: %s (%s)", $body->message ?? 'Unknown error', $response->getStatus() ) );
				}
			} else {
				throw new HideoutException( sprintf( "API error: %s (%s)", $body->message ?? 'Unknown error', $response->getStatus() ) );
			}
		} else {
			throw new HideoutException( sprintf( "API error: %s", $e->getMessage() ) );
		}
		return $ret;
	}

	/**
	 * Store a new entry
	 * @param  string $key  Secret key
	 * @param  string $data Entry data
	 * @return mixed
	 */
	public function store(string $key, string $data) {
		$ret = false;
		$url = sprintf('%s/%s', rtrim($this->server, '/'), 'api/store');
		$headers = [
			'Authorization' => sprintf('Bearer %s', $this->token)
		];
		$fields = [
			'key' => base64_encode($key),
			'data' => base64_encode($data)
		];
		$curly = Curly::newInstance()
			->setMethod('POST')
			->setHeaders($headers)
			->setFields($fields)
			->setURL($url)
			->execute();
		$response = $curly->getResponse();
		if ($response) {
			$body = $response->getBody();
			if ($response->getStatus() == 200) {
				if ($body->result == 'success') {
					$ret = $body->data->entry;
				} else {
					throw new HideoutException( sprintf( "API error: %s (%s)", $body->message ?? 'Unknown error', $response->getStatus() ) );
				}
			} else {
				throw new HideoutException( sprintf( "API error: %s (%s)", $body->message ?? 'Unknown error', $response->getStatus() ) );
			}
		} else {
			throw new HideoutException( sprintf( "API error: %s", $e->getMessage() ) );
		}
		return $ret;
	}

	/**
	 * Retrieve an entry
	 * @param  string $key   Secret key
	 * @param  string $entry Entry UID
	 * @return string
	 */
	public function retrieve(string $key, string $entry) {
		$ret = false;
		$url = sprintf('%s/%s', rtrim($this->server, '/'), 'api/retrieve');
		$headers = [
			'Authorization' => sprintf('Bearer %s', $this->token)
		];
		$fields = [
			'key' => base64_encode($key),
			'entry' => $entry
		];
		$curly = Curly::newInstance()
			->setMethod('POST')
			->setHeaders($headers)
			->setFields($fields)
			->setURL($url)
			->execute();
		$response = $curly->getResponse();
		if ($response) {
			$body = $response->getBody();
			if ($response->getStatus() == 200) {
				if ($body->result == 'success') {
					$ret = base64_decode($body->data->data);
				} else {
					throw new HideoutException( sprintf( "API error: %s (%s)", $body->message ?? 'Unknown error', $response->getStatus() ) );
				}
			} else {
				throw new HideoutException( sprintf( "API error: %s (%s)", $body->message ?? 'Unknown error', $response->getStatus() ) );
			}
		} else {
			throw new HideoutException( sprintf( "API error: %s", $e->getMessage() ) );
		}
		return $ret;
	}

	/**
	 * Delete an entry
	 * @param  string $entry Entry UID
	 * @return string
	 */
	public function delete(string $entry) {
		$ret = false;
		$url = sprintf('%s/%s', rtrim($this->server, '/'), 'api/delete');
		$headers = [
			'Authorization' => sprintf('Bearer %s', $this->token)
		];
		$fields = [
			'entry' => $entry
		];
		$curly = Curly::newInstance()
			->setMethod('POST')
			->setHeaders($headers)
			->setFields($fields)
			->setURL($url)
			->execute();
		$response = $curly->getResponse();
		if ($response) {
			$body = $response->getBody();
			if ($response->getStatus() == 200) {
				if ($body->result == 'success') {
					$ret = true;
				} else {
					throw new HideoutException( sprintf( "API error: %s (%s)", $body->message ?? 'Unknown error', $response->getStatus() ) );
				}
			} else {
				throw new HideoutException( sprintf( "API error: %s (%s)", $body->message ?? 'Unknown error', $response->getStatus() ) );
			}
		} else {
			throw new HideoutException( sprintf( "API error: %s", $e->getMessage() ) );
		}
		return $ret;
	}
}
