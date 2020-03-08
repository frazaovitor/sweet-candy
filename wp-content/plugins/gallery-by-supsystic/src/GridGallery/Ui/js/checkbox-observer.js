/*global jQuery*/

(function (app, $) {

    function CheckboxObserver() {
        this.$observable = $('[data-observable]');
        this.checked = [];
    }

    CheckboxObserver.prototype.reinit = function () {
        this.$observable = $('[data-observable]');
        this.checked = [];
    };

    CheckboxObserver.prototype.getAll = function () {
        return this.$observable.refresh();
    };

    CheckboxObserver.prototype.getChecked = function () {
        this.checked = [];

        $.each(this.getAll(), $.proxy(function (index, checkbox) {
            if (checkbox.checked) {
                this.checked.push(checkbox);
            }
        }, this));

        return this.checked;
    };

    CheckboxObserver.prototype.isFunction = function (func) {
        var getType = {};
        return func && getType.toString.call(func) === '[object Function]';
    };

    CheckboxObserver.prototype.onClick = function (callback) {

        if (!this.isFunction(callback)) {
            throw new Error('Invalid callback function.');
        }

        // this.getAll().click($.proxy(function (event) {
        //     callback(event, this.getChecked());
        // }, this));
        //
        $('[data-container]').on('click', '[data-observable]', $.proxy(function (e) {
            callback(e, this.getChecked());
        }, this));
    };

    CheckboxObserver.prototype.isNone = function () {
        return (this.getChecked().length === 0);
    };

    CheckboxObserver.prototype.isOne = function () {
        return (this.getChecked().length === 1);
    };

    CheckboxObserver.prototype.isMany = function () {
        return (this.getChecked().length > 0);
    };

    CheckboxObserver.prototype.isAll = function () {
        return (this.getChecked().length === this.getAll().length);
    };

    app.Common = app.Common || {};

    var observer = null;

    app.Common.CheckboxObserver = function () {
        if (observer === null) {
            observer = new CheckboxObserver();
        }

        return observer;
    }

}(window.SupsysticGallery = window.SupsysticGallery || {}, jQuery));
