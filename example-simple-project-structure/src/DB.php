<?php

namespace Wordcamp\Prague\Wpify;

class DB {
	public function __construct( string $host, string $username, string $password ) {
		// Init the connection here
	}

	/**
	 * Query DB
	 * @return array
	 */
	public function query(): array {
		return [ 'some-data' => 'Something' ];
	}
}
