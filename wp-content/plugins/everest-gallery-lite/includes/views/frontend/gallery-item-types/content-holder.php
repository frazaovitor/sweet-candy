<div class="eg-content-holder">
    <?php
    if ( in_array('link', $hover_animation_components) || in_array('lightbox', $hover_animation_components) ) {
        switch ( $gallery_item_type ) {
                    case 'image':
                    case 'post':
                    case 'instagram':
                        $icon = '<i class="fa fa-search" aria-hidden="true"></i>';
                        break;   
                    case 'video':
                        $icon = '<i class="fa fa-play" aria-hidden="true"></i>';
                        break;
                    case 'audio':
                       $icon = '<i class="fa fa-music" aria-hidden="true"></i>';
                        break;
                    
                }
        ?>
        <div class="eg-button-holder">
            <?php if ( isset($gallery_details[ 'lightbox' ][ 'lightbox_status' ]) && in_array('lightbox', $hover_animation_components) ) { ?>
                <a href="javascript:void(0);" class="eg-zoom"><?php echo $icon;?></a>
            <?php } ?>
            <?php if ( $gallery_item_details[ 'item_link' ] != '' && in_array('link', $hover_animation_components) ) { ?>
                <a href="<?php echo esc_url($gallery_item_details[ 'item_link' ]); ?>" class="eg-link" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a>
            <?php } ?>
        </div>
        <?php
    }
    if ( in_array('title', $hover_animation_components) ) {
        ?>
        <span class="eg-title eg-main-title"><?php echo esc_attr($gallery_item_details[ 'item_title' ]); ?></span>
        <?php
    }
    if ( in_array('title', $hover_animation_components) || in_array('caption', $hover_animation_components) ) {
        ?>
        <div class="eg-caption">
            <?php if ( in_array('title', $hover_animation_components) ) { ?>
                <span class="eg-title" style="display:none"><?php echo esc_attr($gallery_item_details[ 'item_title' ]); ?></span>
            <?php } ?>
            <?php if ( in_array('caption', $hover_animation_components) ) { ?>

                <p><?php echo esc_attr($gallery_item_details[ 'item_caption' ]); ?></p>
            <?php } ?>
        </div>
    <?php } ?>
    <?php if ( $gallery_details[ 'hover' ][ 'overlay_layout' ] == 'layout-32' ) { ?>
        <div class="eg-layout-32-wrap" style="display: none">
            <?php if ( in_array('title', $hover_animation_components) ) { ?>
                <a href="javascript:void(0);" class="eg-layout-more"><?php echo esc_attr($gallery_item_details[ 'item_title' ]); ?></a>
                <?php
            }
            if ( in_array('link', $hover_animation_components) || in_array('lightbox', $hover_animation_components) ) {
                if ( $gallery_item_details[ 'item_link' ] != '' && in_array('link', $hover_animation_components) ) {
                    ?>
                    <a href="<?php echo esc_url($gallery_item_details[ 'item_link' ]); ?>" class="eg-link" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a>
                    <?php
                }
                if ( isset($gallery_details[ 'lightbox' ][ 'lightbox_status' ]) && in_array('lightbox', $hover_animation_components) ) {
                    ?>
                    <a href="javascript:void(0);" class="eg-zoom"><i class="fa fa-search" aria-hidden="true"></i></a>
                        <?php
                    }
                }
                ?>
        </div>
    <?php } ?>
</div>