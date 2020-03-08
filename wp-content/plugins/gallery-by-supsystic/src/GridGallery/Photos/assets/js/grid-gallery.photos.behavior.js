(function ($) {

    $(document).ready(function () {

        /* Some settings */
        var defaultStyle = 'z-index: 10',
            ajaxUrl = $('#gg-btn-upload').data('ajax-url');


        /* Make folders are droppable */
        initDroppable($);

        /* Make photos are draggable */
        initDraggable($);

        /* Make all items are sortable */

        var $itemsContainer = $('.sg-photos');

        if (typeof $itemsContainer !== 'undefined' || $itemsContainer !== false) {

            if (!$.isFunction($.fn.sortable)) {
                return;
            }

            $itemsContainer.sortable({
                start: function (event, ui) {
                    ui.item.draggable({
//                        revert: 'invalid'
                    });
                },

                stop: function (event, ui) {
                    ui.item.find('.ui-draggable').attr('style', defaultStyle);
                    ui.item.addClass('animated swing');
                    ui.item.draggable('destroy');
                }
            });
        }

        /* Enable trash button when at least one item is selected && enable edit button when one item is selected */
        initToolbar($);
    });

})(jQuery);

function initDroppable($) {

    $('[data-type="folder"]').droppable({
        hoverClass: 'gg-hover-folder',
        drop:       function (event, ui) {

            event.preventDefault();

            var container = ui.draggable.parent(),
                folderId = $(this).data('id'),
                photoId = ui.draggable.data('id'),
                $this = $(this),
                $cb = $('.gg-checkbox:checked'),
                photos = [];

            if (container.is('.sg-photos')) {
                container = ui.draggable.find('.gg-item');
                photoId = container.data('id');
            }

            if ($cb.length > 0) {

                $cb.each(function () {
                    var $entity = $(this).parent().parent();

                    if ($entity.data('type') == 'photo') {
                        photos.push($entity);
                    }
                });

                if (confirm('Do you wanna move the ' + photos.length + ' selected photos to the folder?')) {
                    $.each(photos, function (i, v) {
                            $.post(wp.ajax.settings.url, {
                            action:    'grid-gallery',
                            _wpnonce: SupsysticGallery.nonce,
                            route:     {
                                module: 'photos',
                                action: 'move'
                            },
                            folder_id: folderId,
                            photo_id:  v.data('id')
                        }, function (r) {

                            if (r.error) {
                                $.jGrowl('Unable to move photo to the selected folder');
                            } else {
                                v.parent().remove();
                            }

                        });
                    });
                }
            }

            $.post(wp.ajax.settings.url, {

                action:    'grid-gallery',
                _wpnonce: SupsysticGallery.nonce,
                route:     {
                    module: 'photos',
                    action: 'move'
                },
                folder_id: folderId,
                photo_id:  photoId

            }, function (response) {

                if (response.error) {
                    $.jGrowl('Unable to move photo to the selected folder');
                    return;
                }

                container.addClass('animated flipOutX');

                setTimeout(function () {

                    if (container.parent().is('.gg-list-item')) {
                        container.parent().remove();
                    }

                    container.remove();

                    var counter = $this.find('.gg-folder-photos-num');

                    counter.text(parseInt(counter.text()) + 1);

                    $('.sg-photos').sortable('refreshPositions').sortable('refresh');

                }, 500);

            });
        }
//        }
    });
}
function initDraggable($) {
//    $('[data-type="photo"]').draggable({

//        handle: '.fa-arrows',
//        revert: 'invalid'
//    });

}

function initToolbar($) {

    /* Toolbar buttons */
    var $buttons = {};

    $('.supsystic-bar-controls').find('.button').each(function () {

        this.buttonName = this.id.replace('gg-btn-', '');

        $buttons[this.buttonName] = $(this);

    });

    $('.gg-checkbox').on('click', function () {


        var n = $('input.gg-checkbox:checked').length;

        disableButton($buttons.delete);
        disableButton($buttons.edit);
        disableButton($buttons.attach);
        disableButton($buttons.attachNew);

        /* trash, attach & attachNew buttons */
        if (n > 0) {
            enableButton($buttons.delete);
            enableButton($buttons.attach);
            enableButton($buttons.attachNew);
        }

        /* pencil button */
        if (n === 1) {

            enableButton($buttons.edit);

        }

    });
}

function disableButton($button) {
    if (typeof $button != 'undefined' && $button != false) {
        $button.attr('disabled', 'disabled');
    }
}

function enableButton($button) {
    if (typeof $button != 'undefined' && $button != false) {
        $button.removeAttr('disabled');
    }
}
