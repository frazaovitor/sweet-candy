(function ($) {
    /**
     * Replace certain portion of the string
     *
     * @param {string} str
     * @param {string} find
     * @param {string} replace
     * @return {string}
     *
     * @since 1.0.0
     */
    function eg_replace(str, find, replace) {
        return str.replace(new RegExp(find, 'g'), replace);
    }
    /**
     *
     * @type object
     */
    var notice_timeout;

    /**
     * Defining global variable for notice from localization
     *
     * @type object eg_backend_js_object.strings
     *
     * @since 1.0.0
     */
    var notices = eg_backend_js_object.strings;

    /**
     * Generates required notice
     *
     * @param {string} info_text
     * @param {string} info_type
     *
     */
    function eg_generate_info(info_text, info_type) {
        clearTimeout(notice_timeout);
        switch (info_type) {
            case 'error':
                var info_html = '<p class="eg-error">' + info_text + '</p>';
                break;
            case 'info':
                var info_html = '<p class="eg-info">' + info_text + '</p>';
                break;
            case 'ajax':
                var info_html = '<p class="eg-ajax"><img src="' + eg_backend_js_object.plugin_url + 'images/ajax-loader.gif" class="eg-ajax-loader"/>' + info_text + '</p>';
            default:
                break;

        }
        $('.eg-notice-head').html(info_html).show();
        if (info_type != 'ajax') {
            notice_timeout = setTimeout(function () {
                $('.eg-notice-head').slideUp(1000);
            }, 5000);
        }

    }

    /**
     * Checkbox switch initialization
     *
     * @since 1.0.0
     */
    function initialize_checkbox_switch() {

        $('input[type="checkbox"].eg-gallery-form-field').each(function () {

            if (!$(this).hasClass('eg-normal-checkbox') && !$(this).hasClass('eg-switch-initialized')) {
                $(this).addClass('eg-switch-initialized');
                $(this).wrap('<label class="eg-checkbox-switch"></label>');
                $(this).after('<div class="eg-checkbox-slider eg-round"></div>');

            }
        });
    }



    /**
     * Get a random integer between `min` and `max`.
     *
     * @param {number} min - min number
     * @param {number} max - max number
     * @return {int} a random integer
     */
    function eg_getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }

    /**
     * Generates random string
     *
     * @param {int} length
     * @returns {string}
     *
     * @since 1.0.0
     */
    function eg_generate_random_string(length) {
        var string = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var random_string = '';
        for (var i = 1; i <= length; i++) {
            random_string += string[eg_getRandomInt(0, 61)];
        }
        return random_string;

    }

    /**
     * Image Upload via WP Media Upload
     *
     * @since 1.0.0
     */
    var mediaUploader;

    function eg_image_gallery_add() {
        var filters = {};

        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        // Extend the wp.media object
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: notices.upload_popup_title,
            button: {
                text: notices.upload_popup_button_label
            }, multiple: true});

        // When a file is selected, grab the URL and perform necessary task to display as the gallery items
        mediaUploader.on('select', function () {
            attachment = mediaUploader.state().get('selection').toJSON();

            if ($('.eg-filter-tag').length > 0) {
                $('.eg-filter-tag').each(function () {
                    var filter_key = $(this).data('filter-key');
                    var filter_label = $(this).data('filter-label');
                    filters[filter_key] = filter_label;
                });

            }
            var data = {
                action: 'eg_generate_image_gallery_html',
                _wpnonce: eg_backend_js_object.ajax_nonce,
                attachments: attachment,
                filters: filters
            };

            $.ajax({
                type: 'post',
                url: eg_backend_js_object.ajax_url,
                data: data,
                beforeSend: function (xhr) {
                    $('.eg-backend-popup').hide();
                    eg_generate_info(notices.ajax_notice, 'ajax');
                },
                success: function (res) {
                    $('.eg-notice-head').slideUp(500, function () {
                        $(this).html('');
                    });
                    $('.eg-without-filter-gallery-items-wrap').append(res);


                    $('.eg-without-filter-gallery-items-wrap').sortable({
                        handle: ".eg-move-item",
                        containment: "parent"
                    });
                    initialize_checkbox_switch();



                }
            });


            //$('#image-url').val(attachment.url);
        });
        // Open the uploader dialog
        mediaUploader.open();
    }

    /**
     * Clears all the fields values of gallery item add form
     *
     * @since 1.0.0
     *
     */
    function reset_gallery_item_form(gallery_type) {
        $('.eg-' + gallery_type + '-gallery-item-popup .eg-' + gallery_type + '-form-field').each(function () {
            if (!$(this).hasClass('eg-' + gallery_type + '-type-trigger')) {
                $(this).val('');
            }
        });

    }



    $(function () {
        initialize_checkbox_switch();


        /**
         * Tabs Section Show Hide
         *
         * @since 1.0.0
         */
        $('.eg-section-tab').click(function () {
            $('.eg-section-tab').removeClass('eg-active-tab');
            $(this).addClass('eg-active-tab');
            var section_ref = $(this).data('tab-id');
            $('.eg-gallery-section-wrap').hide();
            $('.eg-gallery-section-wrap[data-section-ref="' + section_ref + '"]').show();
        });


        /**
         * Shortcode generation on Alias Keyup
         *
         * @since 1.0.0
         */
        $('#eg-gallery-add-alias').keyup(function () {
            if ($(this).val() != '') {
                var alias = $(this).val();
                var shortcode = '[everest_gallery alias="' + alias + '"]';
                $('#eg-gallery-add-shortcode').val(shortcode);
            } else {
                $('#eg-gallery-add-shortcode').val('');
            }
        });
        $('#eg-alias').keyup(function () {
            if ($(this).val() != '') {
                var alias = $(this).val();
                var shortcode = '[everest_gallery alias="' + alias + '"]';
                $('#eg-shortcode').val(shortcode);
            } else {
                $('#eg-shortcode').val('');
            }
        });








        /**
         * Extra Option Popup Display
         *
         * @since 1.0.0
         */
        $('.eg-add-gallery-item').click(function () {
            var gallery_item_type = $(this).data('gallery-item-type');
            switch (gallery_item_type) {
                case 'image':
                    eg_image_gallery_add();
                    break;

            }
        });

        /**
         * Popup close on overlay click
         *
         * @since 1.0.0
         */
        $('body').on('click', '.eg-overlay', function () {
            $(this).parent().hide();
            $('.eg-gallery-popup-form').hide();
        });



        /**
         * Gallery Item Remove
         *
         * @since 1.0.0
         */

        $('body').on('click', '.eg-delete-item', function () {
            if (confirm(notices.item_removal_notice)) {
                $(this).closest('.eg-each-gallery-item').fadeOut(500, function () {
                    $(this).remove();
                });
            }
        });

        /**
         * Gallery Items Sortable for Filter Gallery Items
         *
         * @since 1.0.0
         */
        $('.eg-filter-gallery-items').sortable({
            handle: ".eg-move-item",
            containment: "parent"
        });

        /**
         * Gallery Items Sortable for Without Filter Gallery Items
         *
         * @since 1.0.0
         */
        $('.eg-without-filter-gallery-items-wrap').sortable({
            handle: ".eg-move-item",
            containment: "parent"
        });

        /**
         * Popup close
         *
         * @since 1.0.0
         */
        $('body').on('click', '.eg-close-popup', function () {
            $(this).closest('.eg-backend-popup').find('.eg-overlay').click();
            $(this).closest('.eg-gallery-item-detail-wrap').find('.eg-overlay').click();
        });


        /**
         * Show settings configuration section
         *
         * @since 1.0.0
         */
        $('body').on('click', '.eg-settings-item', function () {
            $(this).closest('.eg-each-gallery-item').find('.eg-gallery-item-detail-wrap').show();
        });

        /**
         * Display the Add Gallery Popup
         *
         * @since 1.0.0
         */
        $('.eg-add-gallery-popup-trigger').click(function () {
            $('.eg-gallery-add-form, .eg-gallery-popup-form').fadeIn(500);
        });

        /**
         * Add Gallery Trigger
         *
         * @since 1.0.0
         */
        $('#eg-gallery-add-trigger').click(function () {
            var title = $('#eg-gallery-add-title').val();
            var alias = $('#eg-gallery-add-alias').val();
            var gallery_type = $('#eg-gallery-add-gallery-type').val();
            var gallery_item_type = $('#eg-gallery-add-gallery-item-type').val();
            var error_flag = 0;
            if (title == '') {
                error_flag = 1;
                $('#eg-gallery-add-title-error').html(notices.title_blank_notice).show();
            }
            if (alias == '') {
                error_flag = 1;
                $('#eg-gallery-add-alias-error').html(notices.alias_blank_notice).show();
            }
            if (error_flag == 0) {
                $.ajax({
                    url: eg_backend_js_object.ajax_url,
                    type: 'post',
                    data: {
                        title: title,
                        alias: alias,
                        gallery_type: gallery_type,
                        gallery_item_type: gallery_item_type,
                        _wpnonce: eg_backend_js_object.ajax_nonce,
                        action: 'eg_add_gallery_action'
                    },
                    beforeSend: function (xhr) {
                        $('.eg-add-gallery-loader').show();
                        $('.eg-add-gallery-message').html('');
                    },
                    success: function (res) {
                        $('.eg-add-gallery-loader').hide();
                        res = $.parseJSON(res);
                        if (res.error == 0) {
                            $('.eg-add-gallery-message').html(res.success_message).removeClass('eg-error').addClass('eg-success');
                            window.location = res.redirect_url;
                        } else {
                            $('.eg-add-gallery-message').html(res.error_message).addClass('eg-error');
                            //  window.location = res.redirect_url;
                        }
                    }
                });
            }
        });

        /**
         * Remove error on keyup
         *
         * @since 1.0.0
         */
        $('.eg-keyup-trigger').keyup(function () {
            $(this).parent().find('.eg-error').html('');
        });





        /**
         * Save Gallery
         *
         * @since 1.0.0
         */
        $('#eg-save-gallery').click(function () {
            var posted_values = [];
            $('.eg-gallery-form-field').each(function () {
                var field_type = $(this).attr('type');
                var field_name = $(this).attr('name');
                var field_value = $(this).val();
                if (field_type == 'checkbox' || field_type == 'radio') {
                    if ($(this).is(':checked')) {
                        posted_values.push(field_name + '=' + field_value);
                    }
                } else {
                    posted_values.push(field_name + '=' + field_value);

                }
            });
            posted_values = encodeURI(posted_values.join('&'));
            $.ajax({
                url: eg_backend_js_object.ajax_url,
                type: 'post',
                data: {
                    posted_values: posted_values,
                    action: 'eg_gallery_save_action',
                    _wpnonce: eg_backend_js_object.ajax_nonce,
                },
                beforeSend: function (xhr) {
                    eg_generate_info(notices.ajax_notice, 'ajax');
                },
                success: function (res) {
                    var res = $.parseJSON(res);
                    if (res.success == 0) {
                        eg_generate_info(res.message, 'error');
                    } else {
                        eg_generate_info(res.message, 'info');
                    }

                }
            });


        });

        /**
         * Gallery delete
         *
         * @since 1.0.0
         */
        $('.eg-delete').click(function () {
            selector = $(this);

            if (confirm(notices.gallery_delete_notice)) {
                var gallery_id = $(this).data('gallery-id');
                $.ajax({
                    url: eg_backend_js_object.ajax_url,
                    type: 'post',
                    data: {
                        gallery_id: gallery_id,
                        action: 'eg_gallery_delete_action',
                        _wpnonce: eg_backend_js_object.ajax_nonce,
                    },
                    beforeSend: function (xhr) {
                        eg_generate_info(notices.ajax_notice, 'ajax');
                    },
                    success: function (res) {
                        var res = $.parseJSON(res);
                        if (res.success == 0) {
                            eg_generate_info(res.message, 'error');
                        } else {
                            selector.closest('tr').css('background', '#ff6969').fadeOut(1500, function () {
                                $(this).remove();
                            });
                            eg_generate_info(res.message, 'info');
                        }

                    }
                });

            }

        });

        /**
         * Layoutwise options display
         *
         * @since 1.0.0
         */
        $('.eg-gallery-layout-type').change(function () {
            var layout_type = $(this).val();
            $('.eg-layout-options').hide();
            $('.eg-' + layout_type + '-options').show();
        });



        /**
         * Hover Type trigger
         *
         * @since 1.0.0
         */
        $('select[name="gallery_details[hover][hover_type]"]').change(function () {
            $('.eg-hover-options').hide();
            $('.eg-' + $(this).val() + '-options').show();
        });


        /**
         * Jquery UI Slider initialization
         *
         * @since 1.0.0
         */

        $('.eg-ui-slider').each(function () {
            var $selector = $(this);
            var min = $(this).data('min');
            var max = $(this).data('max');
            var value = $(this).data('value');
            $(this).slider({
                range: 'min',
                min: min,
                max: max,
                value: value,
                slide: function (event, ui) {
                    $selector.parent().find('input[type="number"]').val(ui.value);
                    console.log(event);
                    console.log(ui);
                }
            });
        });

        /**
         * Hover Animation Select
         *
         * @since 1.0.0
         */
        $('.eg-hover-layouts input[type="checkbox"]').change(function () {
            $('.eg-hover-layouts input[type="checkbox"]').attr('checked', false);
            $(this).attr('checked', true);
        });

        /**
         * Media Upload Button initialization
         *
         * @since 1.0.0
         */
        $('body').on('click', '.eg-media-upload-button', function () {
            var $selector = $(this);
            var button_label = $(this).data('button-label');
            var window_title = $(this).data('window-title');
            // If the uploader object has already been created, reopen the dialog
            if (mediaUploader) {
                //   mediaUploader.open();
                // return;
            }
            // Extend the wp.media object
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: window_title,
                button: {
                    text: button_label
                }, multiple: false
            });

            // When a file is selected, grab the URL and perform necessary task to display as the gallery items
            mediaUploader.on('select', function () {
                attachment = mediaUploader.state().get('selection').toJSON();
                // console.log(attachment);
                var attachment_id = attachment[0].id;
                var attachment_url = attachment[0].url;
                // alert(attachment_id);
                $selector.parent().find('input[type="text"]').val(attachment_url);
                $selector.parent().find('input[type="hidden"]').val(attachment_id);
                if (button_label == 'Choose Image') {
                    if ($selector.parent().find('.eg-settings-preview-image').length > 0) {
                        $selector.parent().find('.eg-settings-preview-image').attr('src', attachment_url);
                    } else {
                        $selector.after('<img src="' + attachment_url + '" class="eg-settings-preview-image"/>');

                    }
                }
                if ($selector.data('preview-image')) {
                    $selector.closest('.eg-each-gallery-item').find('.eg-preview-image').attr('src', attachment_url);
                }


                //$('#image-url').val(attachment.url);
            });
            // Open the uploader dialog
            mediaUploader.open();
        });



        $(window).on("load", function () {
            $(".eg-popup-inner-wrap").mCustomScrollbar();
        });




        /**
         * Gallery Items Copy
         *
         *@since 1.0.0
         */
        $('body').on('click', '.eg-copy-item', function () {
            var gallery_id = $(this).closest('.eg-each-gallery-item').data('gallery-item-key');
            var copy_gallery_id = 'eg_item_' + eg_generate_random_string(15);
            var copy_item = $(this).closest('.eg-each-gallery-item').clone().html();

            copy_item = eg_replace(copy_item, gallery_id, copy_gallery_id);
            copy_item = '<div class="eg-each-gallery-item" data-gallery-item-key="' + copy_gallery_id + '">' + copy_item + '</div>';
            $(this).closest('.eg-each-gallery-item').after(copy_item);
            $(".eg-popup-inner-wrap").mCustomScrollbar();
        });


        /**
         * Gallery Copy
         *
         * @since 1.0.0
         */
        $('.eg-copy').click(function () {
            var gallery_id = $(this).data('gallery-id');
            $.ajax({
                url: eg_backend_js_object.ajax_url,
                type: 'post',
                data: {
                    gallery_id: gallery_id,
                    action: 'eg_copy_gallery',
                    _wpnonce: eg_backend_js_object.ajax_nonce,
                },
                beforeSend: function (xhr) {
                    eg_generate_info(notices.ajax_notice, 'ajax');
                },
                success: function (res) {
                    var res = $.parseJSON(res);
                    if (res.error == 1) {
                        eg_generate_info(res.error_message, 'error');
                    } else {
                        eg_generate_info(res.success_message, 'info');
                        window.location = res.redirect_url;
                        exit;
                    }

                }
            });
        });


        $('.eg-preview-trigger').change(function () {
            var layout = $(this).val();
            $(this).closest('.eg-field').find('.eg-preview-image').hide();
            $(this).closest('.eg-field').find('.eg-preview-image[data-preview-id="' + layout + '"]').show();
        });
        


    });
}(jQuery));
