(function($) {

    $(document).ready(function() {
        initCreateDialog();
    });

    function initCreateDialog() {

        var $container = $('.supsystic-container'),
            $trigger = $('#gg-create-gallery-link, #btn-add-new');

        var request = {
            action: 'grid-gallery',
            title:  'Untitled gallery',
            _wpnonce: SupsysticGallery.nonce,
            route:  {
                module: 'galleries',
                action: 'create'
            }
        };

        if (typeof $container === 'undefined' || $container === false)  {
            // console.log('The "Create gallery" popup window was not initialized: Container not found.');
            return;
        }

        if (typeof $trigger === 'undefined' || $trigger === false) {
            // console.log('The "Create gallery" popup window trigger is undefined');
            return;
        }

        var submitGallery = (function () {
            /* Window layers */
            var layers = {
                text:   $('#gg-create-gallery-text'),
                loader: $('#gg-create-gallery-loader')
            };

            /* Gallery title */
            var title = $container.find('input').val(),
                preset = $container.find('#presetValue').val();

            if (!title) {
                //$container.find('#newGalleryAlert').show();
                return false;
            }

            layers.text.hide();
            layers.loader.show();

            if (title) {

                request = $.extend('', request, {
                    title: title,
                    preset: preset
                });

                $.post(wp.ajax.settings.url, request, function (response) {
                    $.jGrowl(response.message);

                    if (!response.error) {
                        window.location.href = response.url;
                    }

                    //$container.dialog('close');
                    //$container.find('#newGalleryAlert').hide();
                });

            }

            layers.text.show();
            layers.loader.hide();
        });
        /*$container.dialog({
            modal:    true,
            autoOpen: false,
            width: 750,
            height: 565,
            buttons:  {
                OK: function() {
                    submitGallery();
                },
                Cancel: function() {
                    $container.dialog('close');
                }
            },
            open: function (event, ui) {
                $(this).css({ height: 575 });
            }
        });*/

        /*$(document).keypress(function (e) {
            if (e.which == 13) {
                submitGallery();
            }
        });*/

        $(document).ready(function () {
            var $presets = $('.preset:not(.disabled)'),
                $field = $('#presetValue');

            $presets.first().addClass('active');

            $presets.on('click', function () {
                $presets.removeClass('active');
                $(this).addClass('active');

                $field.val($(this).data('preset'));
                $('#gallery-create-title').focus();
            });

            $('#gallery-create').on('click', function() {
                /* Window layers */
                var layers = {
                    text:   $('#gg-create-gallery-text'),
                    loader: $('#gg-create-gallery-loader')
                };

                /* Gallery title */
                var title = $container.find('input').val(),
                    preset = $container.find('#presetValue').val();

                $(this).find('i').removeClass('fa-check').addClass('fa-spinner fa-spin');
                layers.text.hide();
                layers.loader.show();

                request = $.extend('', request, {
                    title: (title ? title : ''),
                    preset: preset
                });

                $.post(wp.ajax.settings.url, request, function (response) {
                    $.jGrowl(response.message);

                    if (!response.error) {
                        window.location.href = response.url;
                    }

                    //$container.dialog('close');
                    $container.find('#newGalleryAlert').hide();
                });

                layers.text.show();
                layers.loader.hide();
            });
            $('#gallery-create-form').on('submit', function() {
                $('#gallery-create').click();
                return false;
            });
            $('#gallery-create-title').focus();
            /*$('#gallery-cancel').on('click', function() {
                $('#gg-create-gallery-dialog').dialog('close');
            });*/
        });

        $(document).on('click', '#delete-gallery', function(event) {
            return confirm($(this).data('confirm'));
        });

    }

})(jQuery);
