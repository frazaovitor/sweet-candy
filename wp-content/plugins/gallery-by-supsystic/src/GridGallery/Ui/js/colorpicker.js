(function ($) {
    $(document).ready(function () {
        $('.gg-color-picker').wpColorPicker({
        	change: function(event) {
                setTimeout(function () {
                    $(event.target).trigger('change', event.originalEvent);
                }, 50);
            },
            clear: function(event) {
                setTimeout(function () {
                    $(event.target).siblings('.gg-color-picker').trigger('change');
                }, 50);
            }
        });
    });
}(jQuery))
