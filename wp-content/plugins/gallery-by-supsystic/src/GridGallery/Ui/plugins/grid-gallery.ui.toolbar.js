(function ($) {

    $.fn.ggToolbar = function (config) {

        var defaults = {};

        config = $.extend({}, config, defaults);

        $('.supsystic-bar-controls li > button', this).on('click', function (e) {

            var buttonName = this.dataset.button,
                callback = config.onClick[buttonName],
                checked = $('.gg-checkbox:checked').parent().parent();

            if (typeof callback !== 'function') {
                throw new Error('Callback is not a function.');
            }

            callback(e, $(this), checked);

        });

        $('.gg-checkbox').on('click', function (e) {

            if (config.onCheck === 'undefined' || config.onCheck === false) {
                return;
            }

            if (config.onCheck.length < 1) {
                return;
            }

            $.each(config.onCheck, function (button, callback) {

                var $btn = $('[data-button="' + button + '"]'),
                    checked = $('.gg-checkbox:checked').parent().parent();

                callback(e, $btn, checked);

            });

        });
    };

})(jQuery);