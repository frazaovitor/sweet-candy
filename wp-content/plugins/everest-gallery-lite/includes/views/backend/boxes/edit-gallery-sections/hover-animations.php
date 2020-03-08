<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<div class="eg-gallery-section-wrap" data-section-ref="hover-animations" style="display:none;">
    <div class="eg-field-wrap">
        <label><?php _e('Hover Type', 'everest-gallery-lite'); ?></label>
        <div class="eg-field">
            <?php $hover_type = (isset($gallery_details[ 'hover' ][ 'hover_type' ])) ? esc_attr($gallery_details[ 'hover' ][ 'hover_type' ]) : 'overlay'; ?>
            <select name="gallery_details[hover][hover_type]" class="eg-gallery-form-field">
                <option value="overlay" <?php selected($hover_type, 'overlay'); ?>><?php _e('Show overlay', 'everest-gallery-lite') ?></option>
                <option value="no-hover" <?php selected($hover_type, 'no-hover'); ?>><?php _e('No Hover Animations', 'everest-gallery-lite'); ?></option>
            </select>
        </div>
    </div>`
    <div class="eg-hover-options eg-overlay-options" <?php $this->eg_display_none($hover_type, 'overlay'); ?>>
        <div class="eg-field-wrap eg-full-width">
            <label class="header"><?php _e('Hover Animation Components', 'everest-gallery-lite'); ?></label>

        </div>
        <?php
        $hover_animation_components = isset($gallery_details[ 'hover' ][ 'hover_animation_components' ]) ? array_map('esc_attr', $gallery_details[ 'hover' ][ 'hover_animation_components' ]) : array();
        ?>
        <div class="eg-field-wrap">
            <label><?php _e('Lightbox Button', 'everest-gallery-lite') ?></label>
            <div class="eg-field">
                <input type="checkbox" name="gallery_details[hover][hover_animation_components][]" value="lightbox" class="eg-gallery-form-field" <?php echo (in_array('lightbox', $hover_animation_components)) ? 'checked="checked"' : ''; ?>/>
                <p class="description"><?php _e('Note: You will need to enable the lightbox in the lightbox section too to display this button', 'everest-gallery-lite'); ?></p>
            </div>
        </div>
        <div class="eg-field-wrap">
            <label><?php _e('Link Button', 'everest-gallery-lite') ?></label>
            <div class="eg-field">
                <input type="checkbox" name="gallery_details[hover][hover_animation_components][]" value="link" class="eg-gallery-form-field" <?php echo (in_array('link', $hover_animation_components)) ? 'checked="checked"' : ''; ?>/>
                <p class="description"><?php _e('Note: The link button will only show if link is filled when adding gallery items', 'everest-gallery-lite'); ?></p>
            </div>
        </div>
        <div class="eg-field-wrap">
            <label><?php _e('Title', 'everest-gallery-lite') ?></label>
            <div class="eg-field">
                <input type="checkbox" name="gallery_details[hover][hover_animation_components][]" value="title" class="eg-gallery-form-field" <?php echo (in_array('title', $hover_animation_components)) ? 'checked="checked"' : ''; ?>/>
            </div>
        </div>
        <div class="eg-field-wrap">
            <label><?php _e('Caption', 'everest-gallery-lite') ?></label>
            <div class="eg-field">
                <input type="checkbox" name="gallery_details[hover][hover_animation_components][]" value="caption" class="eg-gallery-form-field" <?php echo (in_array('caption', $hover_animation_components)) ? 'checked="checked"' : ''; ?>/>
                <p class="description"><?php _e('Note: For hover animation layout 31, it has been disabled.', 'everest-gallery-lite'); ?></p>
            </div>
        </div>

        <div class="eg-field-wrap eg-full-width">
            <label class="header"><?php _e('Overlay Effects', 'everest-gallery-lite'); ?></label>
            <div class="eg-field">
                <?php
                $overlay_layout = isset($gallery_details[ 'hover' ][ 'overlay_layout' ]) ? esc_attr($gallery_details[ 'hover' ][ 'overlay_layout' ]) : 'layout-1';
                for ( $i = 1; $i <= 5; $i++ ) {
                    ?>
                    <label class="eg-hover-layouts eg-hover-layout-<?php echo $i; ?>">
                        <input type="checkbox" name="gallery_details[hover][overlay_layout]" value="layout-<?php echo $i; ?>" class="eg-gallery-form-field eg-normal-checkbox" <?php checked($overlay_layout, 'layout-' . $i); ?>/>
                        <span class="eg-radio-title"><?php echo __('Layout', 'everest-gallery-lite') . ' ' . $i; ?></span>
                        <div class="eg-overlay-wrapper">
                            <img src="<?php echo EGL_IMG_DIR . 'preview-image.jpg'; ?>"/>
                            <div class="eg-mask">
                                <div class="eg-inner-wrapper">
                                    <div class="eg-content-holder">
                                        <div class="eg-button-holder">
                                            <a href="javascript:void(0);" class="eg-icon-search"><i class="fa fa-search"></i></a>
                                            <a href="javascript:void(0);" class="eg-icon-chain"><i class="fa fa-chain"></i></a>
                                        </div>
                                        <span class="eg-title eg-main-title"><?php _e('Title', 'everest-gallery-lite'); ?></span>
                                        <div class="eg-caption">
                                            <span class="eg-title" style="display:none"><?php _e('Title', 'everest-gallery-lite'); ?></span>
                                            <p><?php _e('Caption goes here', 'everest-gallery-lite'); ?></p>
                                        </div>
                                        <div class="eg-layout-32-wrap" style="display: none">
                                            <a href="javascript:void(0);" class="eg-layout-more"><?php _e('Title', 'everest-gallery-lite'); ?></a>
                                            <a href="javascript:void(0);" class="eg-icon-chain"><i class="fa fa-chain"></i></a>
                                            <a href="javascript:void(0);" class="eg-icon-search"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <span class="add" style="display: none">
                                    <i class="fa fa-plus"></i>
                                </span>
                                <div class="eg-caption-holder" style="display: none">
                                    <span class="eg-title"><?php _e('Title', 'everest-gallery-lite'); ?></span>
                                    <p><?php _e('Caption goes here', 'everest-gallery-lite'); ?></p>
                                </div>
                            </div>
                        </div>
                    </label>
                    <?php
                }
                ?>
            </div>
        </div>

    </div>

</div>