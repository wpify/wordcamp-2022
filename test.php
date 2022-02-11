<?php
/*
 * Plugin Name:       WordCamp Prague 2022
 * Description:       Plugin made for WordCamp Prague 2022
 * Version:           1.0
 * Requires PHP:      7.4.0
 * Requires at least: 5.3.0
 * Author:            WPify
 * Author URI:        https://wpify.io
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wordcampprague
 * Domain Path:       /languages
*/

new class {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function enqueue_scripts() {
        $this->enqueue_script( 'app', 'app-script', 'script' );
        $this->enqueue_script( 'app', 'app-style', 'style' );
    }

    public function enqueue_script( $name, $handle, $type ) {
        $asset = require __DIR__ . '/build/app.asset.php';
        $deps  = $asset['dependencies'];
        $ver   = $asset['version'];

        if ( $type === 'script' ) {
            $src = plugins_url( 'build/' . $name . '.js', __FILE__ );
            wp_enqueue_script( $handle, $src, $deps, $ver, true );
        } elseif ( $type === 'style' ) {
            $src = plugins_url( 'build/' . $name . '.css', __FILE__ );
            wp_enqueue_style( $handle, $src, array(), $ver );
        }
    }
};

