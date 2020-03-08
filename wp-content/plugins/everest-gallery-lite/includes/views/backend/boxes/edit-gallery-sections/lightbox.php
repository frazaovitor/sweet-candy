<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<div class="eg-gallery-section-wrap" data-section-ref="lightbox" style="display:none;">
    <div class="eg-field-wrap">
        <label><?php _e('Enable Lightbox', 'everest-gallery-lite'); ?></label>
        <div class="eg-field">
            <?php $lightbox_check = isset($gallery_details[ 'lightbox' ][ 'lightbox_status' ]) ? esc_attr($gallery_details[ 'lightbox' ][ 'lightbox_status' ]) : 0; ?>
            <input type="checkbox" name="gallery_details[lightbox][lightbox_status]" value="1" class="eg-gallery-form-field" <?php checked($lightbox_check, true); ?>/>
            <p class="description"><?php _e('Please check if you want to enable lightbox in this gallery', 'everest-gallery-lite'); ?></p>
        </div>
    </div>
    <div class="eg-field-wrap" style="display: none;">
        <label><?php _e('Choose Lightbox', 'everest-gallery-lite'); ?></label>
        <div class="eg-field">
            <select name="gallery_details[lightbox][lightbox_type]" class="eg-gallery-form-field">
                <?php
                $lightbox_array = array( 'pretty_photo' => 'Pretty Photo' );

                /**
                 * Filters Lightbox types
                 *
                 * @param array $lightbox_array
                 * @since 1.0.0
                 */
                $lightbox_array = apply_filters('eg_lightbox_array', $lightbox_array);
                $selected_lightbox = isset($gallery_details[ 'lightbox' ][ 'lightbox_type' ]) ? esc_attr($gallery_details[ 'lightbox' ][ 'lightbox_type' ]) : 'pretty_photo';
                foreach ( $lightbox_array as $lightbox_option => $lightbox_value ) {
                    ?>
                    <option value="<?php echo $lightbox_option ?>" <?php selected($selected_lightbox, $lightbox_option); ?>><?php echo $lightbox_value ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="eg-lightbox-options" data-lightbox-type="pretty_photo" <?php $this->eg_display_none($selected_lightbox, 'pretty_photo'); ?>>
        <div class="eg-field-wrap">
            <label><?php _e('Lightbox Theme', 'everest-gallery-lite'); ?></label>
            <div class="eg-field">
                <?php $selected_theme = isset($gallery_details[ 'lightbox' ][ 'pretty_photo' ][ 'theme' ]) ? esc_attr($gallery_details[ 'lightbox' ][ 'pretty_photo' ][ 'theme' ]) : 'pp_default'; ?>
                <select name="gallery_details[lightbox][pretty_photo][theme]" class="eg-gallery-form-field">
                    <option value="pp_default" <?php selected($selected_theme, 'pp_default'); ?>><?php _e('Default', 'everest-gallery-lite'); ?></option>
                    <option value="light_rounded" <?php selected($selected_theme, 'light_rounded'); ?>><?php _e('Light Rounded', 'everest-gallery-lite'); ?></option>
                    <option value="dark_rounded" <?php selected($selected_theme, 'dark_rounded'); ?>><?php _e('Dark Rounded', 'everest-gallery-lite'); ?></option>
                    <option value="light_square" <?php selected($selected_theme, 'light_square'); ?>><?php _e('Light Square', 'everest-gallery-lite'); ?></option>
                    <option value="dark_square" <?php selected($selected_theme, 'dark_square'); ?>><?php _e('Dark Square', 'everest-gallery-lite'); ?></option>
                    <option value="facebook" <?php selected($selected_theme, 'facebook'); ?>><?php _e('Facebook', 'everest-gallery-lite'); ?></option>
                </select>
            </div>
        </div>
        <div class="eg-field-wrap">
            <label><?php _e('Social Tools', 'everest-gallery-lite'); ?></label>
            <div class="eg-field">
                <?php $checked_social_tool = isset($gallery_details[ 'lightbox' ][ 'pretty_photo' ][ 'social_tools' ]) ? esc_attr($gallery_details[ 'lightbox' ][ 'pretty_photo' ][ 'social_tools' ]) : 0; ?>
                <input type="checkbox" name="gallery_details[lightbox][pretty_photo][social_tools]" value="1" <?php checked($checked_social_tool, true); ?> class="eg-gallery-form-field"/>
                <p class="description"><?php _e('Please check if you want to enable social sharing(Twitter and Facebook) inside the lightbox', 'everest-gallery-lite'); ?></p>
            </div>
        </div>
    </div>


</div>

