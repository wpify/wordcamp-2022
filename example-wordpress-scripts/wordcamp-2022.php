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

namespace WordCamp2022Example;

class Plugin {
    public function __construct() {
        // Enqueue scripts and styles on the frontend.
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        // Inline sprites, so we can use it later on.
        add_action( 'wp_body_open', array( $this, 'inline_svgsprite' ) );

        // Print a nice star from SVG sprite on the page.
        add_action( 'wp_body_open', array( $this, 'print_svg_star' ) );
    }

    public function enqueue_scripts() {
        $this->enqueue_script( 'app', 'app-script', 'script' );
        $this->enqueue_script( 'app', 'app-style', 'style' );
    }

    public function enqueue_script( $name, $handle, $type ) {
        $asset = require __DIR__ . '/build/main.asset.php';
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

    public function inline_svgsprite() {
        ?>
        <div style="width:0;height:0;overflow:hidden">
            <?php echo file_get_contents( __DIR__ . '/build/sprites.svg' ); ?>
        </div>
        <?php
    }

    public function print_svg_star() {
        ?>
        <svg class="sprite sprite--star">
            <use xlink:href="#sprite-star"></use>
        </svg>
        <?php
    }
}

function wordcamp2022example() {
    static $plugin;

    if ( empty( $plugin ) ) {
        $plugin = new Plugin();
    }

    return $plugin;
}

add_action( 'plugins_loaded', 'wordcamp2022example', 11 );

