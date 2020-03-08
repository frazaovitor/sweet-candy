<?php

defined('ABSPATH') or die('No script kiddies please!!');
if ( !class_exists('EGL_Admin') ) {

    class EGL_Admin extends EGL_Library {

        /**
         * Includes all the backend functionality
         *
         * @since 1.0.0
         */
        function __construct() {

            add_action('admin_menu', array( $this, 'eg_admin_menu' )); 
            add_filter( 'plugin_row_meta', array( $this, 'eg_lite_plugin_row_meta' ), 10, 2 );
            add_filter( 'admin_footer_text', array( $this, 'eg_lite_admin_footer_text' ) );
            add_action( 'admin_init', array( $this, 'eg_lite_redirect_to_site' ), 1 );
        }

        function eg_lite_redirect_to_site(){
            if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'eg-documentation-wp' ) {
                wp_redirect( 'https://accesspressthemes.com/documentation/everest-gallery-lite' );
                exit();
            }
            if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'eg-premium-wp' ) {
                wp_redirect( 'https://1.envato.market/c/1302794/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Feverest-gallery-responsive-wordpress-gallery-plugin%2F20067428' );
                exit();
            }
        }

        function eg_lite_plugin_row_meta( $links, $file ){

            if ( strpos( $file, 'accesspress-social-login-lite.php' ) !== false ) {
                $new_links = array(
                    'demo' => '<a href="http://demo.accesspressthemes.com/wordpress-plugins/everest-gallery-lite" target="_blank"><span class="dashicons dashicons-welcome-view-site"></span>Live Demo</a>',
                    'doc' => '<a href="https://accesspressthemes.com/documentation/everest-gallery-lite" target="_blank"><span class="dashicons dashicons-media-document"></span>Documentation</a>',
                    'support' => '<a href="http://accesspressthemes.com/support" target="_blank"><span class="dashicons dashicons-admin-users"></span>Support</a>',
                    'pro' => '<a href="https://1.envato.market/c/1302794/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Feverest-gallery-responsive-wordpress-gallery-plugin%2F20067428" target="_blank"><span class="dashicons dashicons-cart"></span>Premium version</a>'
                );

                $links = array_merge( $links, $new_links );
            }

            return $links;
        }
        function eg_lite_admin_footer_text( $text ){
            global $post;
            if ( (isset( $_GET[ 'page' ] ) && in_array($_GET[ 'page' ],array('everest-gallery-lite','eg-how-to-use','eg-about-us','eg-morewp') ) ) ) {
                $link = 'https://wordpress.org/support/plugin/everest-gallery-lite/reviews/#new-post';
                $pro_link = 'https://1.envato.market/c/1302794/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Feverest-gallery-responsive-wordpress-gallery-plugin%2F20067428';
                $text = 'Enjoyed Everest Gallery Lite? <a href="' . $link . '" target="_blank">Please leave us a ★★★★★ rating</a> We really appreciate your support! | Try premium version of <a href="' . $pro_link . '" target="_blank">Everest Gallery</a> - more features, more power!';
                return $text;
            } else {
                return $text;
            }
        }

        /**
         * Everest gallery menu in backend
         *
         * @since 1.0.0
         */
        function eg_admin_menu() {
            $page_title = (isset($_GET[ 'gallery_id' ], $_GET[ 'action' ]) && $_GET[ 'action' ] == 'edit_gallery') ? __('Edit Gallery', 'everest-gallery-lite') : __('All Galleries', 'everest-gallery-lite');
            add_menu_page(__('Everest Gallery Lite', 'everest-gallery-lite'), __('Everest Gallery Lite', 'everest-gallery-lite'), 'manage_options', 'everest-gallery-lite', array( $this, 'gallery_lists' ), 'dashicons-grid-view');
            add_submenu_page('everest-gallery-lite', $page_title, __('All Galleries', 'everest-gallery-lite'), 'manage_options', 'everest-gallery-lite', array( $this, 'gallery_lists' ));
            add_submenu_page('everest-gallery-lite', __('How to Use', 'everest-gallery-lite'), __('How to Use', 'everest-gallery-lite'), 'manage_options', 'eg-how-to-use', array( $this, 'how_to_use' ));
            add_submenu_page('everest-gallery-lite', __('About Us', 'everest-gallery-lite'), __('About Us', 'everest-gallery-lite'), 'manage_options', 'eg-about-us', array( $this, 'about_us' ));
            add_submenu_page('everest-gallery-lite', __('More WordPress Resources', 'everest-gallery-lite'), __('More WordPress Resources', 'everest-gallery-lite'), 'manage_options', 'eg-morewp', array( $this, 'more_wp' ));
            add_submenu_page( 'everest-gallery-lite', __( 'Documentation', 'everest-gallery-lite' ), __( 'Documentation', 'everest-gallery-lite' ), 'manage_options', 'eg-documentation-wp', '__return_false', null, 9 );
            add_submenu_page( 'everest-gallery-lite', __( 'Check Premium Version', 'everest-gallery-lite' ), __( 'Check Premium Version', 'everest-gallery-lite' ), 'manage_options', 'eg-premium-wp', '__return_false', null, 9 );
        }

        /**
         * Gallery Listing
         *
         * @since 1.0.0
         */
        function gallery_lists() {
            if ( isset($_GET[ 'gallery_id' ], $_GET[ 'action' ]) && $_GET[ 'action' ] == 'edit_gallery' ) {
                $gallery_id = intval(sanitize_text_field($_GET[ 'gallery_id' ]));
                global $egwpdb;
                $gallery_row = $egwpdb->get_gallery_row($gallery_id);
                if ( $gallery_row ) {
                    include(EGL_PATH . 'includes/views/backend/edit-gallery.php');
                } else {
                    wp_redirect(admin_url('admin.php?page=everest-gallery-lite'));
                }
            } else {
                include(EGL_PATH . 'includes/views/backend/gallery-lists.php');
            }
        }

        /**
         * Add New Gallery Section
         *
         * @since 1.0.0
         */
        function add_new_gallery() {
            include(EGL_PATH . 'includes/views/backend/add-new-gallery.php');
        }

        /**
         * How to use
         *
         * @since 1.0.0
         */
        function how_to_use() {
            include(EGL_PATH . 'includes/views/backend/how-to-use.php');
        }

        /**
         * About Us
         *
         * @since 1.0.0
         */
        function about_us() {
            include(EGL_PATH . 'includes/views/backend/about-us.php');
        }

        function more_wp() {
            include(EGL_PATH . 'includes/views/backend/more-wordpress-stuffs.php');
        }

    }

    new EGL_Admin();
}