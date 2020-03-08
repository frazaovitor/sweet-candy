(function ($) {

    if (!String.prototype.startsWith) {
        Object.defineProperty(String.prototype, 'startsWith', {
            enumerable: false,
            configurable: false,
            writable: false,
            value: function (searchString, position) {
                position = position || 0;
                return this.lastIndexOf(searchString, position) === position;
            }
        });
    }

    $.fn.forceHttp = function () {
        this.bind('change keyup', function () {
            if (this.value.length < 5) {
                this.value = this.value;
            }

            if (!this.value.startsWith('http') && !this.value.startsWith('https')) {
                this.value = 'http://' + this.value;
            }
        });

        return this;
    };

}(jQuery));

(function ($) {
    $(document).ready(function () {
        // $('input[name="link"]').forceHttp();
    });
}(jQuery));
