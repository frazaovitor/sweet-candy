<?php

defined('ABSPATH') or die('No script kiddies please!!');
if ( !class_exists('EGL_Enqueue') ) {

    class EGL_Enqueue {

        /**
         * Enqueue all the necessary JS and CSS
         *
         * since @1.0.0
         */
        function __construct() {
            add_action('admin_enqueue_scripts', array( $this, 'register_admin_assets' ));
            add_action('wp_enqueue_scripts', array( $this, 'register_frontend_assets' ));
        }

        function register_admin_assets($hook) {
            $page_array = array( 'everest-gallery-lite', 'eg-import-gallery', 'eg-export-gallery', 'eg-how-to-use', 'eg-about-us', 'eg-settings','eg-morewp' );
            if ( isset($_GET[ 'page' ]) && in_array(sanitize_text_field($_GET[ 'page' ]), $page_array) ) {
                $ajax_nonce = wp_create_nonce('eg_ajax_nonce');
                $eg_js_strings = array(
                    'item_add_error_filter' => __('Please add at least a filter before adding an item', 'everest-gallery-lite'),
                    'upload_popup_title' => __('Choose Image - Use Ctrl or Command to select multiple images', 'everest-gallery-lite'),
                    'upload_popup_button_label' => __('Insert into gallery', 'everest-gallery-lite'),
                    'ajax_notice' => __('Please wait', 'everest-gallery-lite'),
                    'item_removal_notice' => __('Are you sure you want to remove this item ?', 'everest-gallery-lite'),
                    'title_blank_notice' => __('Please enter gallery title', 'everest-gallery-lite'),
                    'alias_blank_notice' => __('Please enter gallery alias', 'everest-gallery-lite'),
                    'gallery_delete_notice' => __('Are you sure you want to delete this gallery?', 'everest-gallery-lite'),
                );
                $eg_js_object_array = array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'strings' => $eg_js_strings,
                    'ajax_nonce' => $ajax_nonce,
                    'plugin_url' => EGL_URL
                );

                wp_enqueue_media();
                wp_enqueue_script('eg-custom-scroll-script', EGL_JS_DIR . 'jquery.mCustomScrollbar.concat.min.js', array( 'jquery' ), EGL_VERSION);
                wp_enqueue_script('eg-backend-script', EGL_JS_DIR . 'eg-backend.js', array( 'jquery', 'jquery-ui-sortable', 'eg-custom-scroll-script', 'jquery-ui-slider' ), EGL_VERSION);
                wp_enqueue_style('eg-fontawesome', EGL_CSS_DIR . 'font-awesome.min.css', array(), EGL_VERSION);
                wp_enqueue_style('eg-custom-scroll-style', EGL_CSS_DIR . 'jquery.mCustomScrollbar.css', array(), EGL_VERSION);
                wp_enqueue_style('eg-backend-style', EGL_CSS_DIR . 'eg-backend.css', array(), EGL_VERSION);
                wp_enqueue_style('eg-jquery-ui-style', EGL_CSS_DIR . 'jquery-ui-css-1.12.1.css', array(), EGL_VERSION);
                wp_localize_script('eg-backend-script', 'eg_backend_js_object', $eg_js_object_array);
            }
        }

        function register_frontend_assets() {
            $ajax_nonce = wp_create_nonce('eg_frontend_ajax_nonce');
            $eg_js_strings = array( 'video_missing' => __('Video URL missing', 'everest-gallery-lite') );
            $eg_js_object_array = array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'strings' => $eg_js_strings,
                'ajax_nonce' => $ajax_nonce,
                'plugin_url' => EGL_URL
            );
            /**
             * Styles
             */
            wp_enqueue_style('eg-fontawesome', EGL_CSS_DIR . 'font-awesome.min.css', array(), EGL_VERSION);
            wp_enqueue_style('eg-frontend', EGL_CSS_DIR . 'eg-frontend.css', array(), EGL_VERSION);
            wp_enqueue_style('eg-pretty-photo', EGL_CSS_DIR . 'prettyPhoto.css', array(), EGL_VERSION);

            /**
             * Scripts
             */
            wp_enqueue_script('eg-imageloaded-script', EGL_JS_DIR . 'imagesloaded.min.js', array( 'jquery' ), EGL_VERSION);
            wp_enqueue_script('eg-prettyphoto', EGL_JS_DIR . 'jquery.prettyPhoto.js', array( 'jquery' ), EGL_VERSION);
            wp_enqueue_script('eg-isotope-script', EGL_JS_DIR . 'isotope.js', array(), EGL_VERSION);
            wp_enqueue_script('eg-frontend-script', EGL_JS_DIR . 'eg-frontend.js', array( 'jquery', 'eg-prettyphoto', 'eg-isotope-script', 'eg-imageloaded-script' ), EGL_VERSION);

            /**
             * Localize variables
             */
            wp_localize_script('eg-frontend-script', 'eg_frontend_js_object', $eg_js_object_array);
        }

    }

    new EGL_Enqueue();
}