<?php
defined('ABSPATH') or die('No script kiddies please!');
$desktop_columns = (isset($gallery_details[ 'layout' ][ 'columns' ][ 'desktop' ]) && $gallery_details[ 'layout' ][ 'columns' ][ 'desktop' ] != '') ? esc_attr($gallery_details[ 'layout' ][ 'columns' ][ 'desktop' ]) : 3;
$tablet_columns = (isset($gallery_details[ 'layout' ][ 'columns' ][ 'tablet' ]) && $gallery_details[ 'layout' ][ 'columns' ][ 'tablet' ] != '') ? esc_attr($gallery_details[ 'layout' ][ 'columns' ][ 'tablet' ]) : 3;
$mobile_columns = (isset($gallery_details[ 'layout' ][ 'columns' ][ 'mobile' ]) && $gallery_details[ 'layout' ][ 'columns' ][ 'mobile' ] != '') ? esc_attr($gallery_details[ 'layout' ][ 'columns' ][ 'mobile' ]) : 3;

if ( $eg_mobile_detector->isMobile() && !$eg_mobile_detector->isTablet() ) {
    $column_class = 'eg-column-' . $mobile_columns;
} else if ( $eg_mobile_detector->isTablet() ) {
    $column_class = 'eg-column-' . $tablet_columns;
} else {
    $column_class = 'eg-column-' . $desktop_columns;
}
$gallery_id = $this->generate_random_string(10);
$layout_class = isset($gallery_details[ 'layout' ][ 'grid_masonary_layout' ]) ? 'eg-masonary-' . esc_attr($gallery_details[ 'layout' ][ 'grid_masonary_layout' ]) : 'eg-masonary-layout-1';
if ( isset($gallery_details[ 'hover' ][ 'hover_type' ]) ) {
    $hover_type = esc_attr($gallery_details[ 'hover' ][ 'hover_type' ]);
    switch ( $hover_type ) {
        case 'overlay':
            $animation_class = isset($gallery_details[ 'hover' ][ 'overlay_layout' ]) ? 'eg-overlay-' . esc_attr($gallery_details[ 'hover' ][ 'overlay_layout' ]) : 'eg-overlay-layout-1';
            break;
        case 'no-hover':
            $animation_class = 'eg-no-hover';
            break;
    }
} else {
    $animation_class = 'eg-no-hover';
}
?>
<div class="eg-masonary-wrap eg-wrap <?php echo $column_class; ?> <?php echo $layout_class; ?> <?php echo $components_class; ?>"
     data-desktop-column="<?php echo $desktop_columns; ?>"
     data-tablet-column="<?php echo $tablet_columns; ?>"
     data-mobile-column="<?php echo $mobile_columns; ?>"
     data-lightbox-type="<?php echo esc_attr($gallery_details[ 'lightbox' ][ 'lightbox_type' ]); ?>"
     <?php if ( $gallery_details[ 'lightbox' ][ 'lightbox_type' ] == 'pretty_photo' ) {
         ?>
         data-pretty_photo-theme ="<?php echo esc_attr($gallery_details[ 'lightbox' ][ 'pretty_photo' ][ 'theme' ]); ?>"
         data-pretty_photo-social ="<?php echo isset($gallery_details[ 'lightbox' ][ 'pretty_photo' ][ 'social_tools' ]) ? 'true' : 'false'; ?>"
     <?php } else if ( $gallery_details[ 'lightbox' ][ 'lightbox_type' ] == 'colorbox' ) {
         ?>
         data-colorbox-transition ="<?php echo esc_attr($gallery_details[ 'lightbox' ][ 'colorbox' ][ 'transition_type' ]); ?>"
         <?php
     }
     if ( $gallery_details[ 'lightbox' ][ 'lightbox_type' ] == 'everest_lightbox' ) {
         $lightbox_theme = isset($gallery_details[ 'lightbox' ][ 'everest_gallery' ][ 'lightbox_theme' ]) ? esc_attr($gallery_details[ 'lightbox' ][ 'everest_gallery' ][ 'lightbox_theme' ]) : 'black';
         ?>
         data-lightbox-theme ="<?php echo $lightbox_theme; ?>"
     <?php }
     ?>
     data-gallery-id="<?php echo $gallery_id; ?>"
     data-lightbox-status="<?php echo isset($gallery_details[ 'lightbox' ][ 'lightbox_status' ]) ? 'true' : 'false' ?>"
     <?php
     if ( isset($gallery_details[ 'general' ][ 'css_id' ]) && $gallery_details[ 'general' ][ 'css_id' ] != '' ) {
         echo 'id="' . esc_attr($gallery_details[ 'general' ][ 'css_id' ]) . '"';
     }
     ?>
     >

    <div class="eg-masonary-items-wrap" data-masonary-id="<?php echo $gallery_id; ?>">
        <?php
        if ( count($gallery_details[ 'gallery_items' ]) > 0 ) {

            $gallery_items_array = $gallery_details[ 'gallery_items' ];

            $item_counter = 0;
            $total_items = count($gallery_items_array);
            foreach ( $gallery_items_array as $gallery_item_key => $gallery_item_details ) {
                $item_counter++;
                $gallery_item_type = isset($gallery_item_details[ 'gallery_item_type' ]) ? esc_attr($gallery_item_details[ 'gallery_item_type' ]) : 'image';
                //$this->print_array($gallery_item_details);
                switch ( $gallery_item_type ) {
                    case 'image':
                        include(EGL_PATH . '/includes/views/frontend/gallery-item-types/image.php');
                        break;
                }
                ?>

                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>

</div>


