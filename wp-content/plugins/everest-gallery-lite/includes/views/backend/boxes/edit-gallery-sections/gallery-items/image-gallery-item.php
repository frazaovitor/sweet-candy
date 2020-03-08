<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<div class="eg-each-gallery-item" data-gallery-item-key="<?php echo $gallery_item_key; ?>">
    <div class="eg-gallery-image-preview">
        <div class="eg-gallery-item-actions-wrap">
            <a href="javascript:void(0)" class="eg-move-item"><span><?php _e('Move', 'everest-gallery-lite'); ?></span></a>
            <a href="javascript:void(0)" class="eg-settings-item"><span><?php _e('Settings', 'everest-gallery-lite'); ?></span></a>
            <a href="javascript:void(0)" class="eg-copy-item"><span><?php _e('Copy', 'everest-gallery-lite'); ?></span></a>
            <a href="javascript:void(0)" class="eg-delete-item"><span><?php _e('Delete', 'everest-gallery-lite'); ?></span></a>
        </div>
        <?php
        if ( $gallery_item_type == 'image' ) {
            $image_url_array = wp_get_attachment_image_src(esc_attr($gallery_item_details[ 'attachment_id' ]), 'full');
            $preview_image_url = $image_url_array[ 0 ];
        } else {
            $default_preview_image = EGL_IMG_DIR . 'no-preview.jpg';
            $preview_image_url = (isset($gallery_item_details[ 'post_preview_image_url' ]) && $gallery_item_details[ 'post_preview_image_url' ] != '') ? esc_url($gallery_item_details[ 'post_preview_image_url' ]) : $default_preview_image;
        }
        //$this->print_array($image_url_array);
        ?>
        <img src="<?php echo $preview_image_url; ?>" class="eg-preview-image">
    </div>
    <div class="eg-gallery-item-detail-wrap eg-backend-popup" style="display:none;">
        <div class="eg-overlay"></div>
        <div class="eg-gallery-item-detail-fields">
            <h4><?php _e('Item Details', 'everest-gallery-lite'); ?><span class="dashicons dashicons-no eg-close-popup"></span></h4>
            <div class="eg-popup-inner-wrap">
                <div class="eg-field-wrap">
                    <label><?php _e('Item Title', 'everest-gallery-lite'); ?></label>
                    <div class="eg-field">
                        <input type="text" class="eg-gallery-form-field" name="gallery_details[gallery_items][<?php echo $gallery_item_key; ?>][item_title]" value="<?php echo esc_attr($gallery_item_details[ 'item_title' ]); ?>">
                    </div>
                </div>
                <div class="eg-field-wrap">
                    <label><?php _e('Item Caption', 'everest-gallery-lite'); ?></label>
                    <div class="eg-field">
                        <textarea class="eg-gallery-form-field" name="gallery_details[gallery_items][<?php echo $gallery_item_key; ?>][item_caption]"><?php echo esc_attr($gallery_item_details[ 'item_caption' ]); ?></textarea>
                    </div>
                </div>
                <div class="eg-field-wrap">
                    <label><?php _e('Item Link', 'everest-gallery-lite'); ?></label>
                    <div class="eg-field">
                        <input type="text" class="eg-gallery-form-field" name="gallery_details[gallery_items][<?php echo $gallery_item_key; ?>][item_link]" value="<?php echo esc_url($gallery_item_details[ 'item_link' ]); ?>">
                    </div>
                </div>
                <?php if ( $gallery_item_type == 'post' ) {
                    ?>
                    <div class="eg-field-wrap">
                        <label><?php _e('Preview Image', 'everest-gallery-lite'); ?></label>
                        <div class="eg-field">
                            <input type="text" name="gallery_details[gallery_items][<?php echo $gallery_item_key; ?>][post_preview_image_url]" value="<?php echo $preview_image_url; ?>" class="eg-gallery-form-field"/>
                            <input type="button" class="eg-media-upload-button button-secondary" value="<?php _e('Upload Image', 'everest-gallery-lite'); ?>" data-button-label="<?php _e('Choose Image', 'everest-gallery-lite'); ?>" data-window-title="<?php _e('Choose Image', 'everest-gallery-lite'); ?>" data-preview-image="true"/>
                            <?php if ( $preview_image_url != '' ) {
                                ?>
                                <img src="<?php echo $preview_image_url; ?>" class="eg-settings-preview-image"/>
                            <?php }
                            ?>
                            <input type="hidden" name="gallery_details[gallery_items][<?php echo $gallery_item_key; ?>][post_preview_image_id]" value="<?php echo esc_attr($gallery_item_details[ 'post_preview_image_id' ]); ?>" class="eg-gallery-form-field"/>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="eg-field-wrap">
                    <label><?php _e('Filters', 'everest-gallery-lite'); ?></label>
                    <div class="eg-field eg-gallery-item-filter-wrap" data-item-key="<?php echo $gallery_item_key; ?>">
                        <?php
                        if ( isset($gallery_details[ 'filter_options' ][ 'filters' ]) && count($gallery_details[ 'filter_options' ][ 'filters' ]) > 0 ) {
                            $item_filters = isset($gallery_details[ 'gallery_items' ][ $gallery_item_key ][ 'filters' ]) ? array_map('esc_attr', $gallery_details[ 'gallery_items' ][ $gallery_item_key ][ 'filters' ]) : array();
                            foreach ( $gallery_details[ 'filter_options' ][ 'filters' ] as $filter_key => $filter_details ) {
                                ?>
                                <div class="eg-gallery-item-each-filter eg-inline-block" data-filter-key="<?php echo $filter_key; ?>">
                                    <label><span class="eg-filter-label"><?php echo $filter_details[ 'label' ]; ?></span><input type="checkbox" name="gallery_details[gallery_items][<?php echo $gallery_item_key; ?>][filters][]" value="<?php echo $filter_key; ?>" class="eg-gallery-form-field" <?php echo (in_array($filter_key, $item_filters)) ? 'checked="checked"' : ''; ?>></label>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if ( $gallery_item_type == 'image' ) {
            ?>
            <input type="hidden" class="eg-gallery-form-field" name="gallery_details[gallery_items][<?php echo $gallery_item_key; ?>][attachment_id]" value="<?php echo $gallery_details[ 'gallery_items' ][ $gallery_item_key ][ 'attachment_id' ]; ?>">
            <?php
        } else {
            ?>
            <input type="hidden" class="eg-gallery-form-field" name="gallery_details[gallery_items][<?php echo $gallery_item_key; ?>][post_id]" value="<?php echo esc_attr($gallery_details[ 'gallery_items' ][ $gallery_item_key ][ 'post_id' ]); ?>"/>
            <?php
        }
        ?>
        <input type="hidden" class="eg-gallery-form-field" name="gallery_details[gallery_items][<?php echo $gallery_item_key; ?>][gallery_item_type]" value="<?php echo $gallery_item_type; ?>">
    </div>
</div>