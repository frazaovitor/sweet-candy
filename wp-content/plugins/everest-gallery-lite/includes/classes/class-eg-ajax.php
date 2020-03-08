<?php

defined('ABSPATH') or die('No script kiddies please!!');
if ( !class_exists('EGL_Ajax') ) {

    class EGL_Ajax extends EGL_Library {

        /**
         * All the frontend ajax related tasks are hooked
         *
         * @since 1.0.0
         */
        function __construct() {
            
        }

        function no_permission() {
            die('No script kiddies please!!');
        }

    }

    new EGL_Ajax();
}
