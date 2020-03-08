<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<div class="eg-gallery-section-wrap" data-section-ref="general">
    <div class="eg-field-wrap">
        <label><?php _e('Title', 'everest-gallery-lite'); ?></label>
        <div class="eg-field">
            <input type="text" class="eg-gallery-form-field" name="gallery_details[general][title]" value="<?php echo esc_attr($gallery_row[ 'gallery_title' ]); ?>"/>
        </div>
    </div>
    <div class="eg-field-wrap">
        <label><?php _e('Alias', 'everest-gallery-lite'); ?></label>
        <div class="eg-field">
            <input type="text" class="eg-gallery-form-field" name="gallery_details[general][alias]" id="eg-alias" value="<?php echo esc_attr($gallery_row[ 'gallery_alias' ]); ?>"/>
        </div>
    </div>

    <div class="eg-field-wrap">
        <label><?php _e('CSS ID', 'everest-gallery-lite'); ?></label>
        <div class="eg-field">
            <input type="text" name="gallery_details[general][css_id]" class="eg-gallery-form-field" value="<?php echo isset($gallery_details[ 'general' ][ 'css_id' ]) ? esc_attr($gallery_details[ 'general' ][ 'css_id' ]) : ''; ?>"/>
        </div>
    </div>
</div>