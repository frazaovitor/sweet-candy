<?php

defined('ABSPATH') or die('No script kiddies please!!');
if ( !class_exists('EGL_Admin_Ajax') ) {

    class EGL_Admin_Ajax extends EGL_Library {

        /**
         * All the ajax related tasks are hooked
         *
         * @since 1.0.0
         */
        function __construct() {
            /**
             * Generate image gallery HTML
             */
            add_action('wp_ajax_eg_generate_image_gallery_html', array( $this, 'generate_image_gallery_html' ));
            add_action('wp_ajax_nopriv_eg_generate_image_gallery_html', array( $this, 'no_permission' ));

            /**
             * Generate image gallery HTML
             */
            add_action('wp_ajax_eg_generate_post_gallery_html', array( $this, 'generate_post_gallery_html' ));
            add_action('wp_ajax_nopriv_eg_generate_post_gallery_html', array( $this, 'no_permission' ));

            /**
             * Gallery Save
             */
            add_action('wp_ajax_eg_gallery_save_action', array( $this, 'save_gallery' ));
            add_action('wp_ajax_nopriv_eg_gallery_save_action', array( $this, 'no_permission' ));

            /**
             * Gallery  Add
             */
            add_action('wp_ajax_eg_add_gallery_action', array( $this, 'add_gallery' ));
            add_action('wp_ajax_nopriv_eg_generate_image_gallery_html', array( $this, 'no_permission' ));

            /**
             * Gallery  Delete
             */
            add_action('wp_ajax_eg_gallery_delete_action', array( $this, 'delete_gallery' ));
            add_action('wp_ajax_nopriv_eg_gallery_delete_action', array( $this, 'no_permission' ));


            /**
             * Gallery Copy Action
             */
            add_action('wp_ajax_eg_copy_gallery', array( $this, 'gallery_copy' ));
            add_action('wp_ajax_nopriv_eg_copy_gallery', array( $this, 'no_permission' ));
        }

        function no_permission() {
            die('No script kiddies please!!');
        }

        function generate_image_gallery_html() {
            if ( isset($_POST[ '_wpnonce' ]) && wp_verify_nonce($_POST[ '_wpnonce' ], 'eg_ajax_nonce') ) {
                include(EGL_PATH . 'includes/views/backend/ajax/image-gallery-html.php');
                die();
            } else {
                die('No script kiddies please!!');
            }
        }

        function generate_post_gallery_html() {
            if ( isset($_POST[ '_wpnonce' ]) && wp_verify_nonce($_POST[ '_wpnonce' ], 'eg_ajax_nonce') ) {
                include(EGL_PATH . 'includes/views/backend/ajax/posts-gallery-html.php');
                die();
            } else {
                die('No script kiddies please!!');
            }
        }

        function add_gallery() {
            if ( isset($_POST[ '_wpnonce' ]) && wp_verify_nonce($_POST[ '_wpnonce' ], 'eg_ajax_nonce') ) {
                $title = sanitize_text_field($_POST[ 'title' ]);
                $alias = sanitize_text_field($_POST[ 'alias' ]);
                $gallery_type = sanitize_text_field($_POST[ 'gallery_type' ]);
                $gallery_item_type = sanitize_text_field($_POST[ 'gallery_item_type' ]);
                $response = array( 'error' => 0 );
                $alias_check = $this->check_alias_availability($alias);
                if ( !$alias_check ) {
                    $response[ 'error' ] = 1;
                    $response[ 'error_message' ] = __('Alias already available. Please enter different alias.', 'everest-gallery-lite');
                }
                if ( $response[ 'error' ] == 0 ) {

                    global $wpdb;
                    $insert_check = $wpdb->insert(
                            EGL_GALLERY_TABLE, array(
                        'gallery_title' => $title,
                        'gallery_alias' => $alias,
                        'gallery_details' => maybe_serialize($this->get_default_gallery_details()),
                        'gallery_type' => $gallery_type,
                        'gallery_item_type' => $gallery_item_type,
                        'last_modified' => date("Y-m-d H:i:s"),
                            ), array(
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s'
                            )
                    );
                    //  $wpdb->print_error();
                    //  die('reached');
                    if ( $insert_check ) {
                        $response[ 'success_message' ] = __('Gallery created successfully.Redirecting...', 'everest-gallery-lite');
                        $gallery_id = $wpdb->insert_id;
                        $response[ 'redirect_url' ] = admin_url('admin.php?page=everest-gallery-lite&gallery_id=' . $gallery_id . '&action=edit_gallery');
                    } else {
                        $response[ 'error' ] = 1;
                        $response[ 'error_message' ] = __('There occurred some error. Please try after some time.', 'everest-gallery-lite');
                    }
                }
                echo json_encode($response);
                die();
            } else {
                die('No script kiddies please!!');
            }
        }

        function save_gallery() {
            if ( isset($_POST[ '_wpnonce' ]) && wp_verify_nonce($_POST[ '_wpnonce' ], 'eg_ajax_nonce') ) {
                $response = array();
                $_POST = array_map('stripslashes_deep', $_POST);
                parse_str($_POST[ 'posted_values' ], $received_data);
                $received_data = $this->sanitize_array($received_data);

                $gallery_details = $received_data[ 'gallery_details' ];
                $gallery_id = $received_data[ 'gallery_id' ];
                // $this->print_array($received_data);
                if ( $gallery_details[ 'general' ][ 'title' ] == '' || $gallery_details[ 'general' ][ 'alias' ] == '' ) {
                    $response[ 'success' ] = 0;
                    $response[ 'message' ] = __('Gallery Title and Alias are mandatory', 'everest-gallery-lite');
                } else {
                    $alias = $gallery_details[ 'general' ][ 'alias' ];
                    $alias_check = $this->check_alias_availability($alias, true, $gallery_id);
                    if ( false ) {

                        $response[ 'success' ] = 0;
                        $response[ 'message' ] = __('Alias already available. Please enter different alias.', 'everest-gallery-lite');
                    } else {
                        $update_data = array( 'gallery_title' => $gallery_details[ 'general' ][ 'title' ],
                            'gallery_alias' => $alias,
                            'gallery_details' => maybe_serialize($gallery_details),
                        );
                        global $egwpdb;
                        $update_check = $egwpdb->update_gallery($received_data);
                        if ( $update_check ) {
                            $response[ 'success' ] = 1;
                            $response[ 'message' ] = __('Gallery updated successfully.', 'everest-gallery-lite');
                        } else {
                            $response[ 'success' ] = 0;
                            $response[ 'message' ] = __('There occurred some error. Please try after some time.', 'everest-gallery-lite');
                        }
                    }
                }
                die(json_encode($response));
            } else {
                die('No script kiddies please!');
            }
        }

        function delete_gallery() {
            if ( isset($_POST[ '_wpnonce' ]) && wp_verify_nonce($_POST[ '_wpnonce' ], 'eg_ajax_nonce') ) {
                global $egwpdb;
                $gallery_id = sanitize_text_field($_POST[ 'gallery_id' ]);
                $delete_check = $egwpdb->delete_gallery($gallery_id);
                if ( $delete_check ) {
                    $response[ 'success' ] = 1;
                    $response[ 'message' ] = __('Gallery deleted successfully.', 'everest-gallery-lite');
                } else {
                    $response[ 'success' ] = 0;
                    $response[ 'message' ] = __('There occurred some error. Please try after some time.', 'everest-gallery-lite');
                }
                die(json_encode($response));
            } else {
                die('No script kiddies please!!');
            }
        }

        function gallery_copy() {
            if ( isset($_POST[ '_wpnonce' ], $_POST[ 'gallery_id' ]) && wp_verify_nonce($_POST[ '_wpnonce' ], 'eg_ajax_nonce') ) {
                global $egwpdb;
                $gallery_id = intval(sanitize_text_field($_POST[ 'gallery_id' ]));
                $gallery_row = $egwpdb->get_gallery_row($gallery_id);
                $random_string = $this->generate_random_string(5);
                global $wpdb;
                $insert_check = $wpdb->insert(
                        EGL_GALLERY_TABLE, array(
                    'gallery_title' => $gallery_row[ 'gallery_title' ] . '-' . __('Copy', 'everest-gallery-lite'),
                    'gallery_alias' => $gallery_row[ 'gallery_alias' ] . '-' . $random_string,
                    'gallery_details' => $gallery_row[ 'gallery_details' ],
                    'gallery_type' => $gallery_row[ 'gallery_type' ],
                    'gallery_item_type' => $gallery_row[ 'gallery_item_type' ],
                    'last_modified' => date("Y-m-d H:i:s"),
                        ), array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                        )
                );
                if ( $insert_check ) {
                    $gallery_id = $wpdb->insert_id;
                    $response[ 'success_message' ] = __('Gallery copied successfully.Redirecting...', 'everest-gallery-lite');
                    $response[ 'redirect_url' ] = admin_url('admin.php?page=everest-gallery-lite&gallery_id=' . $gallery_id . '&action=edit_gallery');
                } else {
                    $response[ 'error' ] = 1;
                    $response[ 'error_message' ] = __('There occurred some error. Please try after some time.', 'everest-gallery-lite');
                }
                die(json_encode($response));
            } else {
                die('No script kiddies please!');
            }
        }

    }

    new EGL_Admin_Ajax();
}
