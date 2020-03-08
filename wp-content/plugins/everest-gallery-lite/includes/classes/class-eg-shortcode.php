<?php

defined('ABSPATH') or die('No script kiddies please!!');
if ( !class_exists('EGL_Shortcode') ) {

    /**
     * Frontend Gallery Shortcode
     */
    class EGL_Shortcode extends EGL_Library {

        function __construct() {
            add_shortcode('everest_gallery', array( $this, 'shortcode_manager' ));
        }

        function shortcode_manager($atts) {
            if ( isset($atts[ 'alias' ]) && $atts[ 'alias' ] != '' ) {
                global $egwpdb;
                global $eg_mobile_detector;
                $gallery_row = $egwpdb->get_gallery_row_by_alias($atts[ 'alias' ]);
                if ( $gallery_row != null ) {
                    ob_start();
                    include(EGL_PATH . 'includes/views/frontend/shortcode.php');
                    $gallery = ob_get_contents();
                    ob_end_clean();
                    return $gallery;
                } else {
                    return (sprintf(__('Gallery not found with %s alias', 'everest-gallery-lite'), $atts[ 'alias' ]));
                }
            } else {
                return __('Alias missing in shortcode', 'everest-gallery-lite');
            }
        }

    }

    new EGL_Shortcode();
}

