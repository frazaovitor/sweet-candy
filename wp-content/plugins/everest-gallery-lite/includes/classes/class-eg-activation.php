<?php

defined('ABSPATH') or die('No script kiddies please!!');
if ( !class_exists('EGL_Activation') ) {

    class EGL_Activation {

        /**
         * Executes all the tasks on plugin activation
         *
         * @since 1.0.0
         */
        function __construct() {
            register_activation_hook(EGL_PATH . 'everest-gallery-lite.php', array( $this, 'activation_tasks' ));
        }

        /**
         * All the activation tasks
         *
         *
         * @since 1.0.0
         */
        function activation_tasks() {
            $this->create_tables();
        }

        /**
         * Creates necessary tables
         *
         * @since 1.0.0
         */
        function create_tables() {
            global $wpdb;

            $charset_collate = $wpdb->get_charset_collate();
            $table_name = EGL_GALLERY_TABLE;
            $sql = "CREATE TABLE $table_name (
                    gallery_id mediumint(9) NOT NULL AUTO_INCREMENT,
                    gallery_title varchar(255) NOT NULL,
                    gallery_alias varchar(255) NOT NULL,
                    gallery_details longtext DEFAULT '' NOT NULL,
                    gallery_type varchar(255) NOT NULL,
                    gallery_item_type varchar(255) NOT NULL,
                    last_modified datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                    PRIMARY KEY  (gallery_id)
                  ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }

    }

    new EGL_Activation();
}
