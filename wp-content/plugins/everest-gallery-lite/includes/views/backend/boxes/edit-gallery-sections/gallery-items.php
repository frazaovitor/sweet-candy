<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<div class="eg-gallery-section-wrap" data-section-ref="gallery-items" style="display:none;">
    <div class="eg-field-wrap">
        <div class="eg-field">
            <?php if ( $gallery_row[ 'gallery_item_type' ] != 'mixed' ) {
                ?>
                <a href="javascript:void(0);" class="eg-button-primary eg-add-gallery-item" data-gallery-item-type="<?php echo esc_attr($gallery_row[ 'gallery_item_type' ]); ?>"><?php _e('Add Item') ?></a>
                <?php
            } else {
                ?>
                <a href="javascript:void(0);" class="eg-button-primary eg-add-gallery-item" data-gallery-item-type="image"><i class="fa fa-image"></i><?php _e('Add Image Item', 'everest-gallery-lite'); ?></a>
                <a href="javascript:void(0);" class="eg-button-primary eg-add-gallery-item" data-gallery-item-type="audio"><i class="fa fa-file-audio-o"></i><?php _e('Add Audio Item', 'everest-gallery-lite') ?></a>
                <a href="javascript:void(0);" class="eg-button-primary eg-add-gallery-item" data-gallery-item-type="video"><i class="fa  fa-video-camera"></i><?php _e('Add Video Item', 'everest-gallery-lite'); ?></a>
                <a href="javascript:void(0);" class="eg-button-primary eg-add-gallery-item" data-gallery-item-type="posts"><i class="fa fa-wpforms"></i><?php _e('Add Post Item', 'everest-gallery-lite') ?></a>
                <?php
            }
            ?>
        </div>
    </div>

    <div class="eg-without-filter-wrap">
        <div class="eg-without-filter-gallery-items-wrap clearfix">
            <?php
            if ( isset($gallery_details[ 'gallery_items' ]) && count($gallery_details[ 'gallery_items' ]) ) {
                foreach ( $gallery_details[ 'gallery_items' ] as $gallery_item_key => $gallery_item_details ) {

                    $gallery_item_type = isset($gallery_item_details[ 'gallery_item_type' ]) ? esc_attr($gallery_item_details[ 'gallery_item_type' ]) : 'image';
                    switch ( $gallery_item_type ) {
                        case 'image':
                        case 'post':
                            include(EGL_PATH . '/includes/views/backend/boxes/edit-gallery-sections/gallery-items/image-gallery-item.php');
                            break;
                        case 'video':
                            include(EGL_PATH . '/includes/views/backend/boxes/edit-gallery-sections/gallery-items/video-gallery-item.php');
                            break;
                        case 'audio':
                            include(EGL_PATH . '/includes/views/backend/boxes/edit-gallery-sections/gallery-items/audio-gallery-item.php');
                            break;
                        case 'instagram':
                            include(EGL_PATH . '/includes/views/backend/boxes/edit-gallery-sections/gallery-items/instagram-gallery-item.php');
                            break;
                    }
                }
            }
            ?>
        </div>
    </div>
</div>