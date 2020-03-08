(function($) {
    $(document).ready(function() {

        var $frame = $('#grid-gallery-preview'),
            $back = $('#back');

        /*
         Stop script execution if the current page is not preview.
         */
        if ('preview' !== new URI().query(true).action) {
            return;
        }

        /*
         Prevents the direct redirection in the frame and makes
         redirection in the current window.
         */
        $back.on('click', function(e) {
            e.preventDefault();
            window.location.href = $back.attr('href');
        });

        /*
         Replace admin bar in the frame with the back button.
         */
        $frame.load(function() {
            $frame.contents()
                .find('#wpadminbar')
                .html($back.show());
        });
    });
})(jQuery);
