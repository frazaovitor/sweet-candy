<?php

defined('ABSPATH') or die('No script kiddies please!!');
if ( !class_exists('EGL_Model') ) {

    /**
     * Model class for Gallery
     * Contains all the db related function
     *
     * @since 1.0.0
     *
     */
    class EGL_Model {

        var $egwpdb;

        /**
         * Assigns global $wpdb to egwpdb
         *
         * @global object $wpdb
         *
         * @since 1.0.0
         */
        function __construct() {
            global $wpdb;
            $this->egwpdb = $wpdb;
        }

        /**
         * Fetches all the galleries from DB
         *
         * @return array $galleries
         *
         * @since 1.0.0
         */
        function get_galleries() {
            //$gallery_table = EGL_GALLERY_TABLE;
            $galleries = $this->egwpdb->get_results(sprintf("SELECT * FROM `%s` ORDER BY `gallery_title` ASC", EGL_GALLERY_TABLE), ARRAY_A);
            return $galleries;
        }

        /**
         * Fetches specific gallery row
         *
         * @param int $gallery_id
         * @return array $gallery_row
         *
         * @since 1.0.0
         */
        function get_gallery_row($gallery_id) {
            $gallery_row = $this->egwpdb->get_row(sprintf("SELECT * FROM `%s` WHERE gallery_id = %d", EGL_GALLERY_TABLE, $gallery_id), ARRAY_A);
            return $gallery_row;
        }

        /**
         * Updates gallery in the gallery table
         *
         * @param array $received_data
         *
         * @return boolean
         *
         * @since 1.0.0
         */
        function update_gallery($received_data) {
            $gallery_details = $received_data[ 'gallery_details' ];
            $gallery_title = $gallery_details[ 'general' ][ 'title' ];
            $gallery_alias = $gallery_details[ 'general' ][ 'alias' ];
            $gallery_id = $received_data[ 'gallery_id' ];
            $last_modified_date = date("Y-m-d H:i:s");
            $update_check = $this->egwpdb->update(
                    EGL_GALLERY_TABLE, array(
                'gallery_title' => $gallery_title,
                'gallery_alias' => $gallery_alias,
                'gallery_details' => maybe_serialize($gallery_details),
                'last_modified' => $last_modified_date
                    ), array( 'gallery_id' => $gallery_id ), array(
                '%s',
                '%s',
                '%s',
                '%s'
                    ), array( '%d' )
            );
            return $update_check;
        }

        /**
         * Deletes Gallery
         *
         * @param int $gallery_id
         * @return boolean $delete_check
         *
         * @since 1.0.0
         */
        function delete_gallery($gallery_id) {
            $delete_check = $this->egwpdb->delete(EGL_GALLERY_TABLE, array( 'gallery_id' => $gallery_id ), array( '%d' ));
            return $delete_check;
        }

        /**
         * Get gallery id by alias
         *
         * @param string $alias
         * @return array $gallery_row
         *
         * @since 1.0.0
         */
        function get_gallery_row_by_alias($alias = '') {
            $gallery_row = $this->egwpdb->get_row(sprintf("SELECT * FROM `%s` WHERE gallery_alias = '%s'", EGL_GALLERY_TABLE, $alias), ARRAY_A);
            return $gallery_row;
        }

    }

    $GLOBALS[ 'egwpdb' ] = new EGL_Model;
}