<?php

defined('ABSPATH') or die('No script kiddies please!');
$gallery_details = maybe_unserialize($gallery_row[ 'gallery_details' ]);
//$this->print_array($gallery_details);
$layout = $gallery_details[ 'layout' ][ 'layout_type' ];
$hover_animation_components = isset($gallery_details[ 'hover' ][ 'hover_animation_components' ]) ? array_map('esc_attr', $gallery_details[ 'hover' ][ 'hover_animation_components' ]) : array();
$components_class = (isset($gallery_details[ 'hover' ][ 'hover_animation_components' ])) ? 'eg-component-' . implode('-', $gallery_details[ 'hover' ][ 'hover_animation_components' ]) : '';
if ( file_exists(EGL_PATH . 'includes/views/frontend/layouts/' . $layout . '.php') ) {
    if ( isset($gallery_details[ 'gallery_items' ]) ) {
        include(EGL_PATH . 'includes/views/frontend/layouts/' . $layout . '.php');
    }
} else {
    /**
     * Fires when the layout file is not available in the layouts folder
     * Useful to add new layouts as addon
     *
     * @param array $gallery_row
     *
     * @since 1.0.0
     */
    do_action('eg_extra_layout', $gallery_row);
}




