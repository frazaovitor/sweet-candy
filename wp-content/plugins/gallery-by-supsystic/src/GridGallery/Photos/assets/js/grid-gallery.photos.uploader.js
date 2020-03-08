(function ($, app) {

    var defaults = {
        wp:         null,
        url:        null,
        title:      'Choose image',
        buttonText: 'Choose image',
        debug:      false,
        multiple:   'toggle',
        attachType: null,
        galleryId: null,

        route: {
            module: 'photos',
            action: 'add'
        }
    };

    var uploader;

    $.fn.ggPhotoUploader = function (parameters) {
        parameters = $.extend({}, defaults, parameters);

        if (typeof(parameters.wp) === 'undefined') {
            $.jGrowl('The WordPress Media API is not available.');
            return;
        }

        parameters.url = parameters.wp.ajax ? parameters.wp.ajax.settings.url : '';

        if(parameters.wp.media) {
            uploader = parameters.wp.media.frames.file_frame = parameters.wp.media({
                title:    parameters.title,
                button:   {
                    text: parameters.buttonText
                },
                multiple: parameters.multiple,
                library : { type : 'image'},
            });
        }

        uploader.on('select', function () {
            SupsysticGallery.Loader.show('Please, wait until images will be imported.');

            var attachments = uploader.state().get('selection').toJSON(),
                statusMessage = null;

            if (attachments.length > 1) {
                statusMessage = 'There are %number% photos selected';
            } else {
                statusMessage = 'There is %number% photo selected';
            }

            $.jGrowl(statusMessage.replace('%number%', attachments.length.toString()));

            var $container = $('[data-container]'),
                reload = attachments.length;

            var ajaxPromise = new $.Deferred().resolve();

            function addImageAJAX(attachment) {

                var post = app.Ajax.Post(defaults.route, {
                    attachment_id: attachment.id,
                    folder_id:     $('[data-upload]').data('folder-id'),
                    view_type:     $container.data('container'),
                    attachType: defaults.attachType,
                    galleryId : defaults.galleryId,
					'save_exif_data': $('.ggUseExifData[name="importUseExifData"]').prop('checked') == true ? 1 : 0,
				});

                return post.send(function (response) {
                    if (!response.error) {
                        $container.parents('#containerWrapper').show(function () {
                            $('#gg-alrt').remove();
                        });

                        $container.append(response.photo);
                        $('.supsystic-lazy').ggLazyLoad();
                        if(!--reload) {
                            SupsysticGallery.Loader.hide();
                            //location.reload(true);
                            window.location.search = 'page=supsystic-gallery&module=galleries&action=view&gallery_id='+defaults.galleryId;
                            location.reload(true);
                        }
                    }

                    $.jGrowl(response.message);
                });
            }

            $.each(attachments, function (index, attachment) {
                ajaxPromise = ajaxPromise.then(function() {
                    return addImageAJAX(attachment);
                });
            });
        });

        this.on('click', function (e) {
            if($(this).hasClass('gallery'))
                defaults.attachType = 'gallery';
            defaults.galleryId = $(this).data('gallery-id');
            e.preventDefault();
            if( !$(this).hasClass('disabled') ){
                uploader.open();
            }
        });
    };

})(jQuery, window.SupsysticGallery);
