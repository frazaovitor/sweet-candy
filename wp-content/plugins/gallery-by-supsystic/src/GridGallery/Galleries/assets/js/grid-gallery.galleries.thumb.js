jQuery.ajaxq = function (queue, options)
{
    // Initialize storage for request queues if it's not initialized yet
    if (typeof document.ajaxq == "undefined") document.ajaxq = {q:{}, r:null};

    // Initialize current queue if it's not initialized yet
    if (typeof document.ajaxq.q[queue] == "undefined") document.ajaxq.q[queue] = [];

    if (typeof options != "undefined") // Request settings are given, enqueue the new request
    {
        // Copy the original options, because options.complete is going to be overridden

        var optionsCopy = {};
        for (var o in options) optionsCopy[o] = options[o];
        options = optionsCopy;

        // Override the original callback

        var originalCompleteCallback = options.complete;

        options.complete = function (request, status)
        {
            // Dequeue the current request
            document.ajaxq.q[queue].shift ();
            document.ajaxq.r = null;

            // Run the original callback
            if (originalCompleteCallback) originalCompleteCallback (request, status);

            // Run the next request from the queue
            if (document.ajaxq.q[queue].length > 0) document.ajaxq.r = jQuery.ajax (document.ajaxq.q[queue][0]);
        };

        // Enqueue the request
        document.ajaxq.q[queue].push (options);

        // Also, if no request is currently running, start it
        if (document.ajaxq.q[queue].length == 1) document.ajaxq.r = jQuery.ajax (options);
    }
    else // No request settings are given, stop current request and clear the queue
    {
        if (document.ajaxq.r)
        {
            document.ajaxq.r.abort ();
            document.ajaxq.r = null;
        }

        document.ajaxq.q[queue] = [];
    }
};

(function ($) {
    $(document).ready(function () {

        /* Ajax URL */
        var url = window.wp ? window.wp.ajax.settings.url : '';

        /* Routes */
        var routes = {
            getImages: {
                module: 'galleries',
                action: 'ajaxGetImages'
            },
            resize:    {
                module: 'galleries',
                action: 'ajaxResizeImage'
            }
        };

        /* Queue identifier */
        var queueId = 'thumbnailGenerator';

        /* Current gallery identifier */
        var galleryId = new URI().query(true).gallery_id;

        /* Request trigger button */
        var $button = $('.generateThumbnails');

        if (typeof $button === 'undefined' || $button === false) {
            return;
        }

        /* Logic goes here: */
        $button.on('click', function (e) {

            e.preventDefault();

            $.post(url, {
                action:     'grid-gallery',
                _wpnonce: SupsysticGallery.nonce,
                route:      routes.getImages,
                gallery_id: galleryId
            }, function (response) {

                if (response.error) {
                    return false;
                }

                if (response.photos === 'undefined' || response.photos.length === 0) {
                    return false;
                }

                var settings = {};

                if (response.area.photo_width_unit == '0') {
                    settings.width = response.area.photo_width;
                }

                if (response.area.grid == '0') {
                    if (response.area.photo_height_unit == '0') {
                        settings.height = response.area.photo_height;
                    }
                }


                $.each(response.photos, function () {

                    var image = this;

                    var request = {
                        url:     url,
                        cache:   false,
                        type:    'POST',
                        data:    {
                            action:        'grid-gallery',
                            route:         routes.resize,
                            attachment_id: image.attachment_id
                        },
                        success: function (result) {
                        }
                    };

                    request.data = $.extend({}, request.data, settings);

                    $.ajaxq(queueId, request);

                });

            });

        });
    });
})(jQuery);