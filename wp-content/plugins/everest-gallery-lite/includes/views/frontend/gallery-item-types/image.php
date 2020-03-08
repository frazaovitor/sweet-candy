<div class="eg-each-item <?php echo $animation_class; ?> <?php echo isset($gallery_item_details[ 'filters' ]) ? implode(' ', array_map('esc_attr', $gallery_item_details[ 'filters' ])) : ''; ?>" data-eg-item-key="<?php echo $gallery_item_key; ?>">
    <?php
    $image_source_type = esc_attr($gallery_details[ 'layout' ][ 'image_source_type' ]);
    $gallery_attachment_id = esc_attr($gallery_item_details[ 'attachment_id' ]);
    $attachment_src = wp_get_attachment_image_src($gallery_attachment_id, $image_source_type);
    $attachment_full_src = wp_get_attachment_image_src($gallery_attachment_id, 'full');
    $hover_animation_components = isset($gallery_details[ 'hover' ][ 'hover_animation_components' ]) ? array_map('esc_attr', $gallery_details[ 'hover' ][ 'hover_animation_components' ]) : array();
    ?>
    <div class="eg-masonary-padding">
        <div class="eg-overlay-wrapper">

            <a href="<?php echo $attachment_full_src[ 0 ] ?>"
               data-lightbox-type="<?php echo esc_attr($gallery_details[ 'lightbox' ][ 'lightbox_type' ]); ?>"
               rel="prettyPhoto[gallery_<?php echo $gallery_row[ 'gallery_id' ]; ?>]"
               title="<?php echo esc_attr($gallery_item_details[ 'item_caption' ]); ?>"
               data-item-type="<?php echo $gallery_item_type; ?>"
               data-index="<?php echo $item_counter; ?>"
               data-total-items="<?php echo $total_items; ?>"
               >
                <img src="<?php echo $attachment_src[ 0 ]; ?>" alt="<?php echo $gallery_item_details[ 'item_title' ]; ?>"/>
            </a>
            <div class="eg-mask">
                <div class="eg-inner-wrapper">
                    <?php include(EGL_PATH . 'includes/views/frontend/gallery-item-types/content-holder.php'); ?>
                </div>
                <span class="add" style="display: none">
                    <i class="fa fa-plus"></i>
                </span>
                <?php if ( in_array('title', $hover_animation_components) || in_array('caption', $hover_animation_components) ) { ?>
                    <div class="eg-caption-holder" style="display: none">
                        <?php if ( in_array('title', $hover_animation_components) ) { ?>
                            <span class="eg-title"><?php echo esc_attr($gallery_item_details[ 'item_title' ]); ?></span>
                        <?php } ?>
                        <?php if ( in_array('caption', $hover_animation_components) ) { ?>
                            <p><?php echo esc_attr($gallery_item_details[ 'item_caption' ]); ?></p>
                        <?php } ?>
                    </div>
                <?php }
                ?>
            </div>
            <div class="slider-overlay"></div>
            <?php if ( isset($gallery_details[ 'layout' ][ 'item_icon' ]) ) {
                ?>
                <div class="eg-item-type-icon"><i class="fa fa-file-image-o" aria-hidden="true"></i></div>
                <?php
            }
            ?>
        </div>
        <?php if ( $gallery_details[ 'layout' ][ 'layout_type' ] == 'filmstrip' && in_array('title', $hover_animation_components) || in_array('caption', $hover_animation_components) ) { ?>
            <div class="eg-slider-caption eg-filmstrip-caption">
                <?php if ( in_array('title', $hover_animation_components) ) { ?>
                    <span class="eg-title" style="display:none"><?php echo esc_attr($gallery_item_details[ 'item_title' ]); ?></span>
                    <?php
                }
                if ( in_array('caption', $hover_animation_components) ) {
                    ?>
                    <p><?php echo esc_attr($gallery_item_details[ 'item_caption' ]); ?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>


</div>