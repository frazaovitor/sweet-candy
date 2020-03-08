(function($) {

    $(document).ready(function() {
        var container = $('.sg-photos'),
            ajaxUrl   = wp.ajax.settings.url;


        /* Add dialogs */
        initNewFolderDialog();

        $('#gg-rename-folder').dialog({
            modal:    true,
            autoOpen: false,
            width:    350,
            buttons: {

                Rename: function() {

                    var self = this,
                        data = {

                            action: 'grid-gallery',
                            _wpnonce: SupsysticGallery.nonce,
                            route: { module: 'photos', action: 'updateTitle' },
                            folder_id: $('#gg-rename-fid').val(),
                            folder_name: $('#gg-rename-fname').val()

                        };

                    $.post(wp.ajax.settings.url, data, function(response) {

                        if (!response.error) {

                            $('.gg-item').each(function() {

                                if ($(this).data('type') == 'folder' && $(this).data('id') == data.folder_id) {
                                    $(this).find('span.gg-folder-name').text(data.folder_name);
                                }

                            });

                            $.jGrowl(response.message);

                            $(self).dialog('close');
                        }

                    });
                },

                Cancel: function() {
                    $(this).dialog('close');
                }

            },
            open: function(event, ui) {

                var container = $('.gg-checkbox:checked').parent().parent(),
                    identifier = container.data('id'),
                    title = container.find('span.gg-folder-name').text();

                $('input[name="folder_name"]').val(title);
                $('input[name="folder_id"]').val(identifier);
            }
        });

        $('#gg-choose-gallery').dialog({
            modal:    true,
            autoOpen: false,
            width:    350,
            buttons:  {

                Add: function() {

                    var galleryId = $('#gg-gallery-list').find(':selected').val(),
                        self = this;

                    $.post(wp.ajax.settings.url, {
                        action:     'grid-gallery',
                        _wpnonce: SupsysticGallery.nonce,
                        route:      { module: 'galleries', action: 'attach' },
                        gallery_id: galleryId,
                        resources:  getResourcesList(container)
                    }, function(response) {
                        $.jGrowl(response.message);
                        $(self).dialog('close');
                    });
                },

                Cancel: function() {
                    $(this).dialog('close');
                }

            },
            open: function(event, ui) {

                $.post(wp.ajax.settings.url, {
                    _wpnonce: SupsysticGallery.nonce,
                    action: 'grid-gallery',
                    route:  { module: 'galleries', action: 'list' } },
                function(response) {

                    if (response.galleries) {

                        $.each(response.galleries, function(i, v) {
                            $('#gg-gallery-list').append('<option value="' + v.id + '">' + v.title + '</option>');
                        });

                        $('#gg-choose-gallery-loading').hide();
                        $('#gg-choose-gallery-form').show();

                    } else {
                        // @TODO No galleries exception
                    }
                });
            },
            close: function(event, ui) {
                $('#gg-choose-gallery-form').hide();
                $('#gg-choose-gallery-loading').show();
                $('#gg-gallery-list').html('');
            }
        });

        /* New folder */
        $('#gg-btn-new-folder').on('click', function(e) {
            e.preventDefault();

            $('#gg-new-folder').dialog('open');

        });

        $('#gg-btn-edit').on('click', function(e) {

            e.preventDefault();

            var item = $('input.gg-checkbox:checked').parent().parent();

            if (item.data('type') === 'photo') {
                window.location.href = item.data('edit-link');
                return;

            }

            $('#gg-rename-folder').dialog('open')

        });

        /* Delete */
        $('#gg-btn-delete').on('click', function(e) {
            e.preventDefault();

            var items = { photo: [], folder: [] };

            $(':checked', container).each(function() {
                var item     = $(this).parent().parent(),
                    itemId   = $(item).data('id'),
                    itemType = $(item).data('type');

                items[itemType].push(itemId);
            });

            $.post(wp.ajax.settings.url, {
                action: 'grid-gallery',
                route: { module: 'photos', action: 'delete' },
                data: items
            }, function(response) {
                if (!response.error) {
                    var checked = $(':checked', container),
                        checkedElements = checked.length;

                    checked.each(function() {
                        var item = $($(this).parent().parent());

                        if (checkedElements > 1) {
                            item.parent().fadeOut(function() {
                                $(this).remove();
                            });
                        } else {
                            item.addClass('animated hinge');
                            setTimeout(function() {
                                item.parent().remove();
                            }, 2000);
                        }
                    });
                } else {
                    $.jGrowl('Unable to delete selected items');
                }
            });
        });

        /* Create new gallery from the selected */
        $('#gg-btn-attachNew').on('click', function(e) {

            e.preventDefault();

            var resources = getResourcesList(container);

            // Send request to the controller to create the new gallery
            // If response returns success, then we trying to attach selected items to the gallery
            $.post(wp.ajax.settings.url, {

                action: 'grid-gallery',
                _wpnonce: SupsysticGallery.nonce,
                route:  { module: 'galleries', action: 'create' },
                title:  'Untitled gallery'

            }, function(response) {

                if (!response.error) {

                    $.post(wp.ajax.settings.url, {
                        action:     'grid-gallery',
                        _wpnonce: SupsysticGallery.nonce,
                        route:      { module: 'galleries', action: 'attach' },
                        gallery_id: response.id,
                        resources:  resources
                    }, function(attachResponse) {
                        $.jGrowl(attachResponse.message);
                    });

                }

                $.jGrowl(response.message);
            });
        });

        $('#gg-btn-attach').on('click', function(e) {
            e.preventDefault();

            var requestParameters = {
                resources:  getResourcesList(container),
                gallery_id: null
            };

            $('#gg-choose-gallery').dialog('open');
        });
    });

    function getResourcesList($container) {

        var resources = [];

        $(':checked', $container).each(function() {
            var $item = $(this).parent().parent(),
                type = $item.data('type'),
                id = $item.data('id');

            resources.push({ type: type, id: id });
        });

        return resources;
    }

    function initNewFolderDialog() {

        var container = $('.sg-photos');

        $('#gg-new-folder').dialog({
            modal:    true,
            autoOpen: false,
            width:    350,
            buttons: {

                Create: function() {

                    var self = this,
                        data = {

                            action: 'grid-gallery',
                            _wpnonce: SupsysticGallery.nonce,
                            route:  { module: 'photos', action: 'addFolder' },
                            folder_name: $('#gg-new-folder-name').val()

                        };

                    $.post(wp.ajax.settings.url, data, function(response) {

                        if (!response.error) {
                            container.prepend(response.folder);
                            $(self).dialog('close');
                        }

                        reinit($);

                    });
                },

                Cancel: function() {
                    $(this).dialog('close');
                }

            }
        });
    }

})(jQuery);
