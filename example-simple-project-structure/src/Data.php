<?php

namespace Wordcamp\Prague\Wpify;

class Data {
	public function __construct( private DB $db ) {
	}

	/**
	 * Get some date from DB
	 * @return array
	 */
	public function get_data(): array {
		return $this->db->query();
	}
}
