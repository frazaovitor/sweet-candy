<?php

defined('ABSPATH') or die('No script kiddies please!!');
if ( !class_exists('EGL_Library') ) {

    class EGL_Library {

        /**
         * Prints array in pre format
         *
         * @since 1.0.0
         *
         * @param array $array
         */
        function print_array($array) {
            echo "<pre>";
            print_r($array);
            echo "</pre>";
        }

        /**
         * Generates random string
         *
         * @param int $length
         * @return string
         *
         * @since 1.0.0
         */
        function generate_random_string($length) {
            $string = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $random_string = '';
            for ( $i = 1; $i <= $length; $i++ ) {
                $random_string .= $string[ rand(0, 61) ];
            }
            return $random_string;
        }

        /**
         * Checks alias availability in the gallery table
         *
         * @param string $alias
         * @param boolean $edit_flag
         * @param int $edit_id
         *
         * @return boolean
         *
         * @since 1.0.0
         */
        function check_alias_availability($alias, $edit_flag = false, $edit_id = 0) {
            global $wpdb;
            $gallery_table = EGL_GALLERY_TABLE;
            if ( $edit_flag && $edit_id == 1 ) {
                $query = "SELECT COUNT(*) FROM $gallery_table WHERE gallery_alias = '$alias' AND gallery_id!=$edit_id";
            } else {
                $query = "SELECT COUNT(*) FROM $gallery_table WHERE gallery_alias = '$alias'";
            }
            // echo $query;
            $alias_count = $wpdb->get_var($query);
            //   var_dump($alias_count);
            if ( $alias_count == 0 ) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Sanitizes Multi Dimensional Array
         * @param array $array
         * @param array $sanitize_rule
         * @return array
         *
         * @since 1.0.0
         */
        function sanitize_array($array = array(), $sanitize_rule = array()) {
            if ( !is_array($array) || count($array) == 0 ) {
                return array();
            }

            foreach ( $array as $k => $v ) {
                if ( !is_array($v) ) {

                    $default_sanitize_rule = (is_numeric($k)) ? 'html' : 'text';
                    $sanitize_type = isset($sanitize_rule[ $k ]) ? $sanitize_rule[ $k ] : $default_sanitize_rule;
                    $array[ $k ] = $this->sanitize_value($v, $sanitize_type);
                }
                if ( is_array($v) ) {
                    $array[ $k ] = $this->sanitize_array($v, $sanitize_rule);
                }
            }

            return $array;
        }

        /**
         * Sanitizes Value
         *
         * @param type $value
         * @param type $sanitize_type
         * @return string
         *
         * @since 1.0.0
         */
        function sanitize_value($value = '', $sanitize_type = 'text') {
            switch ( $sanitize_type ) {
                case 'html':
                    $allowed_html = wp_kses_allowed_html('post');
                    return wp_kses($value, $allowed_html);
                    break;
                default:
                    return sanitize_text_field($value);
                    break;
            }
        }

        /**
         * Prints Display None
         *
         * @param string $parameter1
         * @param string $parameter2
         *
         * @since 1.0.0
         */
        function eg_display_none($parameter1, $parameter2) {
            if ( $parameter1 != $parameter2 ) {
                echo 'style="display:none"';
            }
        }

        /**
         * Default Gallery Details
         *
         * @return array
         *
         * @since 1.0.0
         */
        function get_default_gallery_details() {
            $default_gallery_details = array( 'general' => array
                    (
                    'title' => '',
                    'alias' => '',
                    'css_id' => ''
                ),
                'layout' => array
                    (
                    'image_source_type' => 'full',
                    'layout_type' => 'grid',
                    'columns' => array
                        (
                        'desktop' => 3,
                        'tablet' => 3,
                        'mobile' => 3,
                    ),
                    'grid_masonary_layout' => 'layout-1',
                ),
                'hover' => array
                    (
                    'hover_type' => 'overlay',
                    'hover_animation_components' => array( 'link', 'lightbox', 'title', 'caption' ),
                    'overlay_layout' => 'layout-1',
                    'image_filter_type' => 'filter-1'
                ),
                'lightbox' => array
                    (
                    'lightbox_status' => 1,
                    'lightbox_type' => 'pretty_photo',
                    'pretty_photo' => array
                        (
                        'theme' => 'pp_default'
                    )
                )
            );

            return $default_gallery_details;
        }

    }

}