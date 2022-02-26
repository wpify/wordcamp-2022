<?php

namespace Wordcamp\Prague\Wpify;

class Assets {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
	}

	/**
	 * Enqueue styles
	 * @return void
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/style.css' );
	}
}
