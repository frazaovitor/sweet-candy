/*global jQuery*/

(function (app, $) {

    app.Common = app.Common || {};

    app.Common.getParentEntity = function (element) {
        return $(element).parents('[data-entity]');
    }

    app.Common.getParam = function (name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");

        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

}(window.SupsysticGallery = window.SupsysticGallery || {}, jQuery));
