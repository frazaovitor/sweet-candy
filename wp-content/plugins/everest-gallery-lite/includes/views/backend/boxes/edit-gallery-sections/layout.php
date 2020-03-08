<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<div class="eg-gallery-section-wrap" data-section-ref="layout" style="display:none;">
    <div class="eg-field-wrap">
        <label><?php _e('Image Source Type', 'everest-gallery-lite'); ?></label>
        <div class="eg-field">
            <select name="gallery_details[layout][image_source_type]" class="eg-gallery-form-field">
                <option value="full"><?php _e('Original Size', 'everest-gallery-lite'); ?></option>
                <?php
                $selected_image_type = isset($gallery_details[ 'layout' ][ 'image_source_type' ]) ? esc_attr($gallery_details[ 'layout' ][ 'image_source_type' ]) : '';
                $image_sizes = get_intermediate_image_sizes();
                if ( count($image_sizes) > 0 ) {
                    foreach ( $image_sizes as $image_size ) {
                        ?>
                        <option value="<?php echo $image_size; ?>" <?php selected($image_size, $selected_image_type); ?>><?php echo ucfirst(str_replace('_', ' ', $image_size)); ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="eg-field-wrap">
        <label><?php _e('Layout Type', 'everest-gallery-lite'); ?></label>
        <div class="eg-field">
            <select name="gallery_details[layout][layout_type]" class="eg-gallery-form-field eg-gallery-layout-type">
                <?php
                $selected_layout_type = isset($gallery_details[ 'layout' ][ 'layout_type' ]) ? esc_attr($gallery_details[ 'layout' ][ 'layout_type' ]) : 'grid';
                $layout_types = array(
                    'grid' => __('Grid Layout', 'everest-gallery-lite'),
                    'masonary' => __('Masonry Layout', 'everest-gallery-lite'),
                );
                /**
                 * Filters Layout types
                 *
                 * @param array $layout_types
                 * since 1.0.0
                 */
                $layout_types = apply_filters('eg_layout_types', $layout_types);
                foreach ( $layout_types as $layout_type => $layout_type_label ) {
                    ?>
                    <option value="<?php echo $layout_type; ?>" <?php selected($layout_type, $selected_layout_type); ?>><?php echo $layout_type_label; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>


    <?php
    $gallery_details[ 'layout' ][ 'layout_type' ] = (isset($gallery_details[ 'layout' ][ 'layout_type' ])) ? $gallery_details[ 'layout' ][ 'layout_type' ] : 'grid';
    ?>
    <div class="eg-grid-options eg-masonary-options eg-layout-options" <?php echo ($selected_layout_type == 'masonary' || $selected_layout_type == 'grid') ? '' : 'style="display:none"'; ?>>
        <label class="eg-section-heading"><?php _e('Configure Columns', 'everest-gallery-lite') ?></label>
        <div class="eg-field-wrap">
            <label><?php _e('Desktops', 'everest-gallery-lite'); ?></label>
            <div class="eg-field">
                <div class="eg-ui-slider-wrap">
                    <?php
                    $desktop_column = isset($gallery_details[ 'layout' ][ 'columns' ][ 'desktop' ]) ? esc_attr($gallery_details[ 'layout' ][ 'columns' ][ 'desktop' ]) : '3';
                    ?>
                    <div class="eg-ui-slider" data-max="6" data-min="1" data-value="<?php echo $desktop_column; ?>"></div>
                    <input type="number" min="1" name="gallery_details[layout][columns][desktop]" max="5" class="eg-gallery-form-field" value="<?php echo $desktop_column; ?>" readonly="readonly"/>
                </div>
            </div>
        </div>
        <div class="eg-field-wrap">
            <label><?php _e('Tablets/Ipad', 'everest-gallery-lite'); ?></label>
            <div class="eg-field">
                <?php $tablet_columns = isset($gallery_details[ 'layout' ][ 'columns' ][ 'tablet' ]) ? esc_attr($gallery_details[ 'layout' ][ 'columns' ][ 'tablet' ]) : 3; ?>
                <div class="eg-ui-slider-wrap">
                    <div class="eg-ui-slider" data-min="1" data-max="6" data-value="<?php echo $tablet_columns; ?>"></div>
                    <input type="number" min="1" name="gallery_details[layout][columns][tablet]" max="5" class="eg-gallery-form-field" value="<?php echo $tablet_columns; ?>" readonly="readonly"/>
                </div>
            </div>
        </div>
        <div class="eg-field-wrap">
            <label><?php _e('Mobiles', 'everest-gallery-lite'); ?></label>
            <div class="eg-field">
                <?php $mobile_columns = isset($gallery_details[ 'layout' ][ 'columns' ][ 'mobile' ]) ? esc_attr($gallery_details[ 'layout' ][ 'columns' ][ 'mobile' ]) : 3; ?>
                <div class="eg-ui-slider-wrap">
                    <div class="eg-ui-slider" data-min="1" data-max="3" data-value="<?php echo $mobile_columns; ?>"></div>
                    <input type="number" min="1" name="gallery_details[layout][columns][mobile]" max="5" class="eg-gallery-form-field" value="<?php echo $mobile_columns; ?>" readonly="readonly"/>
                </div>
            </div>
        </div>
        <div class="eg-field-wrap">
            <label><?php _e('Grid/Masonary Layout', 'everest-gallery-lite'); ?></label>
            <div class="eg-field">
                <select name="gallery_details[layout][grid_masonary_layout]" class="eg-gallery-form-field eg-preview-trigger">
                    <?php
                    $selected_grid_masonary_layout = isset($gallery_details[ 'layout' ][ 'grid_masonary_layout' ]) ? esc_attr($gallery_details[ 'layout' ][ 'grid_masonary_layout' ]) : 'layout-1';
                    for ( $i = 1; $i <= 2; $i++ ) {
                        ?>
                        <option value="layout-<?php echo $i; ?>" <?php selected($selected_grid_masonary_layout, 'layout-' . $i); ?>><?php echo __('Layout', 'everest-gallery-lite') . ' ' . $i; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <div class="eg-preview-wrap">
                    <?php
                    for ( $i = 1; $i <= 2; $i++ ) {
                        ?>
                        <img src="<?php echo EGL_IMG_DIR . 'previews/grid/grid-layout-' . $i . '.png'; ?>" class="eg-preview-image" data-preview-id="<?php echo 'layout-' . $i; ?>" <?php echo ($selected_grid_masonary_layout != 'layout-' . $i) ? 'style="display:none"' : ''; ?>/>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>