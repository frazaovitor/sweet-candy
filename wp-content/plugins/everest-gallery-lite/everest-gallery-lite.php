<?php

defined('ABSPATH') or die('No script kiddies please!!');
/*
  Plugin Name: Everest Gallery Lite
  Plugin URI: http://access-keys.com/wordpress-plugins/free-responsive-wordpress-gallery-plugin-everest-gallery-lite/
  Description: Gallery plugin for WordPress.
  Version: 	1.0.5
  Author:  	Access Keys
  Author URI:  http://access-keys.com
  License: 	GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Domain Path: /languages
  Text Domain: everest-gallery-lite
 */

/**
 * Plugin Main Class
 *
 * @since 1.0.0
 */
if ( !class_exists('Everest_gallery_lite') ) {

    class Everest_gallery_lite {

        /**
         * Plugin Main initialization
         *
         * @since 1.0.0
         */
        function __construct() {
            $this->define_constants();
            $this->includes();
        }

        /**
         * Necessary Constants Define
         *
         * @since 1.0.0
         */
        function define_constants() {
            global $wpdb;
            defined('EGL_PATH') or define('EGL_PATH', plugin_dir_path(__FILE__));
            defined('EGL_URL') or define('EGL_URL', plugin_dir_url(__FILE__));
            defined('EGL_IMG_DIR') or define('EGL_IMG_DIR', plugin_dir_url(__FILE__) . 'images/');
            defined('EGL_CSS_DIR') or define('EGL_CSS_DIR', plugin_dir_url(__FILE__) . 'css/');
            defined('EGL_JS_DIR') or define('EGL_JS_DIR', plugin_dir_url(__FILE__) . 'js/');
            defined('EGL_VERSION') or define('EGL_VERSION', '1.0.5');
            defined('EGL_GALLERY_TABLE') or define('EGL_GALLERY_TABLE', $wpdb->prefix . 'eg_galleries');
        }

        /**
         * Includes all the necessary files
         *
         * @since 1.0.0
         */
        function includes() {
            include(EGL_PATH . 'includes/classes/class-eg-library.php');
            include(EGL_PATH . 'includes/classes/class-eg-model.php');
            include(EGL_PATH . 'includes/classes/class-eg-mobile-detect.php');
            include(EGL_PATH . 'includes/classes/class-eg-activation.php');
            include(EGL_PATH . 'includes/classes/class-eg-enqueue.php');
            include(EGL_PATH . 'includes/classes/class-eg-admin.php');
            include(EGL_PATH . 'includes/classes/class-eg-admin-ajax.php');
            include(EGL_PATH . 'includes/classes/class-eg-ajax.php');
            include(EGL_PATH . 'includes/classes/class-eg-shortcode.php');
            include(EGL_PATH . 'includes/classes/class-eg-hooks.php');
        }

    }

    $GLOBALS[ 'everest_gallery_lite' ] = new Everest_gallery_lite();
}


