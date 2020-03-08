/*global jQuery*/
(function (app, $) {

    function Controller() {
        this.$addButton = $('[data-button="add"]');

        this.$addButton.attr('disabled', 'disabled');
    }

    Controller.prototype.changeState = function () {
        this.$addButton.attr('disabled', 'disabled');

        $.each($('[data-observable]'), $.proxy(function (index, checkbox) {
            if (checkbox.checked) {
                this.$addButton.removeAttr('disabled');
            }
        }, this));
    };

    Controller.prototype.preventClick = function (event) {
        event.preventDefault();

        $(this).parents('[data-entity]')
            .find('[data-observable]')
            .trigger('click');
    };

    Controller.prototype.getParameterByName = function (name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");

        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    };

    Controller.prototype.selectAll = function () {
        var $total = $('[data-observable]'),
            $checked = $('[data-observable]:checked');

        if ($total.length > $checked.length) {
            $.each($total, function (index, checkbox) {
                var $checkbox = $(checkbox);

                if (!checkbox.checked) {
                    $checkbox.trigger('click');
                }

                if ($checkbox.parent().is('.gg-check')) {
                    $checkbox.parent().addClass('hover');
                }
            });
        } else {
            $.each($total, function (index, checkbox) {
                var $checkbox = $(checkbox);

                if (checkbox.checked) {
                    $checkbox.trigger('click')
                        .removeAttr('checked');
                }

                if ($checkbox.parent().is('.gg-check')) {
                    $checkbox.parent().removeClass('hover');
                }

            });
        }
    };

    Controller.prototype.add = function (event) {

        event.preventDefault();

        var button = event.currentTarget,
            resources = [],
            request = app.Ajax.Post({
            module: 'galleries',
            action: 'attach'
        });

        $.each($('[data-observable]:checked'), function (index, checkbox) {
            var $entity = app.Common.getParentEntity($(checkbox));

            resources.push({
                id:   $entity.data('entity-id'),
                type: $entity.data('entity-type')
            });
        });

        request.add('resources', resources);
        request.add('gallery_id', this.getParameterByName('gallery_id'));
        request.send(function (response, request) {

            /*if (!response.error) {
                window.location.href = button.href;
            }*/

            if (response.message) {
                $.jGrowl(response.message);
            }
        });
    };

    $(document).ready(function () {
        var queryString = new URI().query(true), controller;

        if (queryString.module !== 'galleries' || queryString.action !== 'addImages') {
            return;
        }

        controller = new Controller();

        $('[data-entity-type="folder"] a').on('click', controller.preventClick);
        $('[data-observable]').on('click', $.proxy(controller.changeState, controller));
        $('#gg-btn-select').on('click', $.proxy(controller.selectAll, controller));
        $('[data-button="add"]').on('click', $.proxy(controller.add, controller));
    });

}(window.SupsysticGallery = window.SupsysticGallery || {}, jQuery));