<div class="eg-wrap wrap">
    <div class="eg-header-wrap">
        <h3>
            <span class="eg-admin-title"><?php _e('Gallery Lists', 'everest-gallery-lite'); ?></span>
        </h3>
        <div class="logo">
            <img src="<?php echo EGL_IMG_DIR . 'logo.png'; ?>"/>
        </div>
    </div>
    <div class="eg-add-wrap">
        <a href="javascript:void(0);" class="eg-button-primary eg-add-gallery-popup-trigger"><?php _e('Add New Gallery', 'everest-gallery-lite'); ?></a>
    </div>
    <div class="eg-gallery-list-table-wrap">
        <table class="wp-list-table widefat fixed">
            <thead>
                <tr>
                    <th><?php _e('Title', 'everest-gallery-lite'); ?></th>
                    <th><?php _e('Shortcode', 'everest-gallery-lite'); ?></th>
                    <th><?php _e('Gallery Type', 'everest-gallery-lite'); ?></th>
                    <th><?php _e('Last Modified', 'everest-gallery-lite'); ?></th>
                    <th><?php _e('Action', 'everest-gallery-lite'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                global $egwpdb;
                $gallery_lists = $egwpdb->get_galleries();
                if ( !empty($gallery_lists) ) {
                    $sn = 1;
                    foreach ( $gallery_lists as $gallery_row ) {
                        $copy_nonce = wp_create_nonce('eg-copy-nonce');
                        ?>
                        <tr class="<?php echo ($sn % 2 == 0) ? 'alternate' : ''; ?>">
                            <td><a href="<?php echo admin_url('admin.php?page=everest-gallery-lite&gallery_id=' . $gallery_row[ 'gallery_id' ] . '&action=edit_gallery'); ?>" title="<?php _e('Edit Gallery', 'everest-gallery-lite'); ?>"><?php echo esc_attr($gallery_row[ 'gallery_title' ]); ?></a></td>
                            <td style="width:400px"><input type="text" readonly="readonly" value='[everest_gallery alias="<?php echo $gallery_row[ 'gallery_alias' ]; ?>"]'  onFocus="this.select();"/></td>
                            <td><?php echo ucfirst(esc_attr($gallery_row[ 'gallery_item_type' ])); ?></td>
                            <td><?php echo esc_attr($gallery_row[ 'last_modified' ]); ?></td>
                            <td>
                                <a class="eg-edit" href="<?php echo admin_url('admin.php?page=everest-gallery-lite&gallery_id=' . $gallery_row[ 'gallery_id' ] . '&action=edit_gallery'); ?>" title="<?php _e('Edit Gallery', 'everest-gallery-lite'); ?>"><?php _e('Edit', 'everest-gallery-lite'); ?></a>
                                <a class="eg-copy" href="javascript:void(0);" data-gallery-id="<?php echo $gallery_row[ 'gallery_id' ]; ?>" title="<?php _e('Copy Gallery', 'everest-gallery-lite'); ?>"><?php _e('Copy', 'everest-gallery-lite'); ?></a>
                                <a class="eg-preview" href="<?php echo site_url() . '?eg_preview=true&gallery_alias=' . esc_attr($gallery_row[ 'gallery_alias' ]); ?>" target="_blank" title="<?php _e('Preview', 'everest-gallery-lite'); ?>"><?php _e('Preview', 'everest-gallery-lite'); ?></a>
                                <a class="eg-delete" href="javascript:void(0)" data-gallery-id="<?php echo $gallery_row[ 'gallery_id' ]; ?>" title="<?php _e('Delete Gallery', 'everest-gallery-lite'); ?>"><?php _e('Delete', 'everest-gallery-lite'); ?></a>
                            </td>
                        </tr>
                        <?php
                        $sn++;
                    }
                } else {
                    ?>
                    <tr><td colspan="4"><?php _e('No gallery added yet.', 'everest-gallery-lite'); ?></td></tr>
                    <?php
                }
                ?>

            </tbody>
            <tfoot>
                <tr>
                    <th><?php _e('Title', 'everest-gallery-lite'); ?></th>
                    <th><?php _e('Shortcode', 'everest-gallery-lite'); ?></th>
                    <th><?php _e('Gallery Type', 'everest-gallery-lite'); ?></th>
                    <th><?php _e('Last Modified', 'everest-gallery-lite'); ?></th>
                    <th><?php _e('Action', 'everest-gallery-lite'); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php include(EGL_PATH . 'includes/views/backend/boxes/gallery-add-form.php'); ?>
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
