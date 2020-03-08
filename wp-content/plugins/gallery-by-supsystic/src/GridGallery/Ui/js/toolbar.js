/*global jQuery*/
(function (app, $) {

    function Toolbar(selector) {
        this.$toolbar = $(selector);
        this.$buttons = this.$toolbar.find('[data-toolbar-button]');
        this.splitSign = '|';
    }

    Toolbar.prototype.getButtons = function () {
        return this.$buttons;
    };

    Toolbar.prototype.enable = function (state) {
        this.$buttons.each($.proxy(function (index, button) {
            var $button = $(button);
            var dataset = $button.data('enabled');

            if (typeof(dataset) !== 'undefined') {
                $.each(dataset.split(this.splitSign), function (index, required) {
                    if (required === state) {
                        $button.removeAttr('disabled');
                    }
                });
            }
        }, this));
    };

    Toolbar.prototype.disable = function (state) {
        this.$buttons.each($.proxy(function (index, button) {
            var $button = $(button);
            var dataset = $button.data('disabled');

            if (typeof(dataset !== 'undefined')) {
                $.each(dataset.split(this.splitSign), function (index, required) {
                    if (required === state) {
                        $button.attr('disabled', 'disabled');
                    }
                });
            }
        }, this));
    };

    Toolbar.prototype.disableAll = function () {
        this.$buttons.attr('disabled', 'disabled');
    };

    Toolbar.prototype.enableAll = function () {
        this.$buttons.removeAttr('disabled');
    };

    Toolbar.prototype.onClick = function (id, callback) {
        this.$buttons.each(function () {
            if (this.id === id) {
                $(this).on('click', function (event) {
                    callback(event, $(this));
                });
            }
        });
    };

    app.Ui = app.Ui || {};
    app.Ui.Toolbar = function (selector) {
        return new Toolbar(selector);
    };

}(window.SupsysticGallery = window.SupsysticGallery || {}, jQuery));