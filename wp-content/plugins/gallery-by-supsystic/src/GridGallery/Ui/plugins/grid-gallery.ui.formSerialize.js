(function ($) {

    $.fn.ggFormSerialize = function () {
        var data = {};

        this.find('[name]').each(function () {
            data[this.name] = this.value;
        });

        return data;
    };

})(jQuery);