<?php
/*
Plugin Name: RA Shortcodes Bundle
Plugin URI: https://github.com/webdevsuperfast/ra-shortcodes-bundle
Description: A collection of shortcodes for WordPress built using the Shortcodes Ultimate plugin API.
Version: 1.0.0
Author: Rotsen Mark Acob
Author URI: https://rotsenacob.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ra-shortcodes-bundle
Domain Path: /languages
*/

class RASB_Shortcodes {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'rasb_enqueue_scripts' ) );
        
        add_filter( 'su/data/groups', array( $this, 'rasb_register_groups' ) );

        foreach ( glob( plugin_dir_path( __FILE__ ) . "shortcodes/*.php" ) as $file ) {
            include_once $file;
        }

        //* Mr Image Resize
        if ( !function_exists( 'rasb_image_resize' ) ) {
            require_once( plugin_dir_path( __FILE__ ) . 'lib/rasb-image-resize.php' );
        }

        if ( function_exists( 'rasb_image_resize' ) )
            require_once( plugin_dir_path( __FILE__ ) . 'lib/misc.php' );

        //* Color Luminance
        if ( !function_exists( 'rasb_color_luminance' ) ) {
            require_once( plugin_dir_path( __FILE__ ) . 'lib/luminance.php' );
        }

    }

    public function rasb_register_groups( $groups ) {
        $groups['ra-shortcodes-bundle'] = __( 'RA Shortcodes', 'ra-shortcodes-bundle' );

        return $groups;
    }

    public function rasb_enqueue_scripts() {
        if ( ! is_admin() ) {
            // Shortcode CSS
            wp_register_style( 'rasb-shortcodes', plugin_dir_url( __FILE__ ) . 'public/css/shortcode.css' );
            wp_enqueue_style( 'rasb-shortcodes' );

            // Vein JS
            wp_register_script( 'rasb-vein-js', plugin_dir_url( __FILE__ ) . 'public/js/vein.min.js', array( 'jquery' ), null, true );

            // Countdown JS
            wp_register_script( 'rasb-countdown-js', plugin_dir_url( __FILE__ ) . 'public/js/jquery.countdown.min.js', array( 'jquery' ), null, true );

            // Shortcode JS
            wp_register_script( 'rasb-shortcodes-js', plugin_dir_url( __FILE__ ) . 'public/js/shortcode.min.js', array( 'jquery' ), null, true );
        }
    }
}

new RASB_Shortcodes();
