jQuery(document).ready(function ($) {


    function eg_initialize_lightbox() {
        $('.eg-wrap').each(function () {
            var selector = $(this);
            var lightbox_status = selector.data('lightbox-status');
            if (lightbox_status) {
                var lightbox_type = $(this).data('lightbox-type');
                switch (lightbox_type) {
                    case 'pretty_photo':
                        var theme = selector.data('pretty_photo-theme');
                        var social_tools = selector.data('pretty_photo-social');
                        if (social_tools) {
                            selector.find("a[data-lightbox-type='pretty_photo']").prettyPhoto({
                                theme: theme
                            });
                        } else {
                            selector.find("a[data-lightbox-type='pretty_photo']").prettyPhoto({
                                theme: theme,
                                social_tools: false
                            });
                        }
                        break;

                }
            }
        });
    }


    eg_initialize_lightbox();
    $('body').on('click', '.eg-zoom', function () {
        $(this).closest('.eg-each-item').find('a[data-lightbox-type]').click();
    });


    var masonary_obj = [];
    $('.eg-masonary-items-wrap').each(function () {
        var $selector = $(this);
        var masonary_id = $(this).data('masonary-id');
        masonary_obj[masonary_id] = $selector.imagesLoaded(function () {
            masonary_obj[masonary_id].isotope({
                itemSelector: '.eg-each-item',
                percentPosition: true,
                masonry: {
                    // use element for option
                    columnWidth: '.eg-each-item'
                }
            });
        });
    });



});
