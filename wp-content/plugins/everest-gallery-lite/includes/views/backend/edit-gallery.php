<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<div class="wrap eg-wrap">
    <div class="eg-header-wrap">
        <h3>
            <span class="eg-admin-title"><?php _e('Edit Gallery', 'everest-gallery-lite'); ?></span>
        </h3>
        <div class="logo">
            <img src="<?php echo EGL_IMG_DIR . 'logo.png'; ?>"/>
        </div>
    </div>
    <?php
    $gallery_details = maybe_unserialize($gallery_row[ 'gallery_details' ]);
    ?>
    <div class="eg-form-wrap clearfix">
        <div class="eg-form-section-tabs clearfix">
            <a class="eg-section-tab eg-active-tab" data-tab-id="general" href="javascript:void(0);"><span class="dashicons dashicons-admin-generic"></span><?php _e('General', 'everest-gallery-lite'); ?></a>
            <a class="eg-section-tab" data-tab-id="gallery-items" href="javascript:void(0);"><span class="dashicons dashicons-format-gallery"></span><?php _e('Gallery Items', 'everest-gallery-lite'); ?></a>
            <a class="eg-section-tab" data-tab-id="layout" href="javascript:void(0);"><span class="dashicons dashicons-layout"></span><?php _e('Layout', 'everest-gallery-lite'); ?></a>
            <a class="eg-section-tab" data-tab-id="hover-animations" href="javascript:void(0);"><span class="dashicons dashicons-video-alt2"></span><?php _e('Hover Animations', 'everest-gallery-lite'); ?></a>
            <a class="eg-section-tab" data-tab-id="lightbox" href="javascript:void(0);"><span class="dashicons dashicons-search"></span><?php _e('Lightbox', 'everest-gallery-lite'); ?></a>
        </div>
        <div class="form-wrapper">
            <form method="post" action="" class="eg-gallery-form">
                <div class="eg-shortcode-info">
                    <div class="eg-field-wrap">
                        <label>Shortcode</label>
                        <div class="eg-field">
                            <input type="text" id="eg-shortcode" readonly="readonly" value='[everest_gallery alias="<?php echo esc_attr($gallery_row[ 'gallery_alias' ]); ?>"]' onfocus="this.select();"/>
                        </div>
                    </div>
                </div>
                <?php
                /**
                 * General Section
                 */
                include(EGL_PATH . 'includes/views/backend/boxes/edit-gallery-sections/general.php');


                /**
                 * Gallery Items Section
                 */
                include(EGL_PATH . 'includes/views/backend/boxes/edit-gallery-sections/gallery-items.php');

                /**
                 * Layout Section
                 */
                include(EGL_PATH . 'includes/views/backend/boxes/edit-gallery-sections/layout.php');

                /**
                 * Hover Animations Section
                 */
                include(EGL_PATH . 'includes/views/backend/boxes/edit-gallery-sections/hover-animations.php');



                /**
                 * Lightbox Section
                 */
                include(EGL_PATH . 'includes/views/backend/boxes/edit-gallery-sections/lightbox.php');
                ?>

                <input type="hidden" name="gallery_id" value="<?php echo $gallery_id; ?>" class="eg-gallery-form-field"/>
            </form>
            <div class="eg-clear"></div>
            <div class="eg-form-actions-wrap">
                <a href="javascript:void(0);" id="eg-save-gallery" class="eg-form-actions"><i class="fa fa-floppy-o" aria-hidden="true"></i><span><?php _e('Save', 'everest-gallery-lite'); ?></span></a>
                <a href="<?php echo site_url() . '?eg_preview=true&gallery_alias=' . esc_attr($gallery_row[ 'gallery_alias' ]); ?>" id="eg-preview-gallery" class="eg-form-actions" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i><span><?php _e('Preview', 'everest-gallery-lite'); ?></span></a>
                <a href="<?php echo admin_url('admin.php?page=everest-gallery-lite'); ?>" id="eg-cancel-gallery" class="eg-form-actions"><i class="fa fa-times" aria-hidden="true"></i><span><?php _e('Cancel', 'everest-gallery-lite'); ?></span></a>
            </div>
        </div>
         
    </div>     
    <div class="eg-backend-popup">
        <div class="eg-overlay"></div>
    </div>

    <div class="eg-notice-head"></div>
</div>
<div class="eg-image-wrapper"> 
        <img src="<?php echo EGL_IMG_DIR.'upgrade-top.png';?>"/>
        <a href="http://demo.accesspressthemes.com/wordpress-plugins/everest-gallery/" class="eg-ref-btn eg-color" target="_blank"><?php _e('Demo','everest-gallery-lite');?></a>
        <a href="https://1.envato.market/c/1302794/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Feverest-gallery-responsive-wordpress-gallery-plugin%2F20067428"  target="_blank" class="eg-ref-btn"><?php _e('Buy Now','everest-gallery-lite');?></a>
        <img src="<?php echo EGL_IMG_DIR.'upgrade-bottom.png';?>"/>
        <a href="http://demo.accesspressthemes.com/wordpress-plugins/everest-gallery/" class="eg-ref-btn eg-color" target="_blank"><?php _e('Demo','everest-gallery-lite');?></a>
        <a href="https://1.envato.market/c/1302794/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Feverest-gallery-responsive-wordpress-gallery-plugin%2F20067428"  target="_blank" class="eg-ref-btn"><?php _e('Buy Now','everest-gallery-lite');?></a>
 </div>

