/*global jQuery*/
(function (app, $, ajaxurl) {

    var observer = app.Common.CheckboxObserver();
    var toolbar = app.Ui.Toolbar('#photo-toolbar');

    var Dialog = function (id) {
        this.id = id;
        this.config = {
            modal:    true,
            autoOpen: false,
            width:    350,
            buttons:  {}
        };
    };

    Dialog.prototype.button = function (name, func) {
        this.config.buttons[name] = func;
        return this;
    };

    Dialog.prototype.init = function () {
        if($(this.id).length) {
            $(this.id).dialog(this.config);
        }
    };

    var Controller = function () {
        this.$container = $('[data-container]');
        this.viewType = this.$container.data('container');
    };

    Controller.prototype._initCheckboxes = function () {
        if (this.viewType !== 'block') {
            return false;
        }

        var $entities = $('[data-entity]');
        var $checkboxes = $entities.find('[data-observable]');

        $entities.refresh().hover(function () {
            $(this).find('.gg-check').addClass('hover');
        }, function () {
            if (!$(this).find('[data-observable]').is(':checked')) {
                $(this).find('.gg-check').removeClass('hover');
            }
        });

        $checkboxes.refresh().on('click', function () {
            var _class = 'gg-checked';
            $.each($checkboxes.refresh(), function (index, checkbox) {
                var $container = $(checkbox).parents('.gg-item');
                $(checkbox).is(':checked') ? $container.addClass(_class) : $container.removeClass(_class);
            });
        });

        return true;
    };

    Controller.prototype.initImportDialog = function () {
        if($('#importDialog').length) {
            $dialog = $('#importDialog').dialog({
                autoOpen: false,
                modal:    true,
                width:    570,
                buttons:  {
                    Cancel: function () {
                        $(this).dialog('close');
                    }
                }
            });
            $('#importDialog').on('click', '#gg-btn-upload', function(event) {
                $dialog.dialog('close');
            });
			$('#importDialog').on('click', '#sggUploadVideoFromUrlBtn', function(event) {
				$dialog.dialog('close');
			});
        }

        Controller.prototype.openImportDialog = function () {
            return $('#importDialog').dialog('open');
        };
    };

    Controller.prototype._initColorbox = function () {
        $('[data-colorbox]').colorbox({
            rel:         'grid-gallery',
            fixed:       true,
            maxHeight:   '90%',
            innerHeight: '90%',
            scrolling:   false
        });
        $('#colorbox, #cboxOverlay').css({
            zIndex: 100000
        });
        $('#colorbox').addClass('theme_1');
        $('#cboxOverlay').addClass('theme_1-overlay');
        $(document).on('cbox_complete', function(event) {
            $('#colorbox').find('#cboxContent').css('position', 'relative');
        });
    };

    Controller.prototype.initEffectsDialog = function () {
        $('#effectDialog').dialog({
            autoOpen: false,
            modal:    true,
            width:    740,
            buttons:  {
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
    };

    Controller.prototype.initRenameCategoryDialog = function () {
        $renameDialog = $('#ggRenameCategory').dialog({
            autoOpen: false,
            modal:    true,
            width:    340,
            buttons:  {
                Cancel: function () {
                    $(this).dialog('close');
                },
                Save: function () {
                    $(this).dialog('close');
                    var oldName = $(this).data('old-name'),
                        newName = $(this).find('#newCategoryName').val(),
                        $container = $('ul.gg-sort-entities[data-category="' + oldName + '"');
                    if(newName.length > 0 && $container.length > 0) {
                        $container.attr('data-category', newName);
                        $container.parent().find('.gg-rename-category').html(newName);
                    }
                }
            }
        });
        $('.gg-rename-category').on('click', function(event) {
            $renameDialog.attr('data-old-name', $(this).html());
            $renameDialog.dialog('open');
        });
    };

    Controller.prototype.initMetaDialog = function () {
        $metaDialog = $('#ggImageMetaDialog').dialog({
            autoOpen: false,
            modal:    true,
            width:    540,
            buttons:  {
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });

        $('.metadata-image').on('click', function(event) {
            event.preventDefault();
            var meta = $(this).closest('tr').data('entity-info'),
                $container = $metaDialog.find('.image-meta-list').empty();

            $.each(meta.attachment, function(key, val) {
                if(key != 'compat' && key != 'sizes' && key != 'nonces') {
                    if(typeof(val) == 'object') {
                        $container.append($('<div style="font-weight: bold;">' + key + ': </div>'));
                        $.each(val, function(k, v) {
                            $container.append($('<div style="padding-left: 20px;">' + k + ': ' + v + '</div>'));
                        });
                    } else {
                        if(key == 'modified' || key == 'date') {
                            var d = new Date(val);
                            val = d.toLocaleString();
                        }
                        $container.append($('<div><span style="font-weight: bold;">' + key + '</span>: ' + val + '</div>'));
                    }
                }
            });
            $metaDialog.dialog('open');
        });
    };

    Controller.prototype.openEffectsDialog = function(attachmentId) {
        $('#effectDialog').dialog('open').data('imgCaptionAttachmentId', attachmentId);
    };

    Controller.prototype.initLinkedImagesDialog = function () {

        $linkedImages = $('#linkedImagesDialog').dialog({
            autoOpen: false,
            modal:    true,
            width:    740,
            buttons:  {
                Save: function () {
                    $(this).dialog('close');
                    var id = $(this).data('id'),
                        attachmentsList = [];
                    var $input = $('input[name="linkedImages"][data-id="' + id + '"]');
                    $('.linked-attachments-list .attachments-' + id).find('img').each(function(index, el) {
                        attachmentsList.push($(this).attr('data-attachment-id'));
                    });
                    $input.val(attachmentsList.join(','));
                    $('#photo-editor-' + $(this).data('id')).trigger('submit');
                }
            }
        });

        $addImages = $linkedImages.find('.linked-images-action-buttons .button.add');
        $removeImages = $linkedImages.find('.linked-images-action-buttons .button.remove');

        $imgTemplate = 
        $('<div class="sc-attachment">' +
            '<div class="thumbnail"></div>' +
        '</div>').on('click', function(event) {
            event.preventDefault();
            $(this).toggleClass('selected');
        });

        var frame;

        $addImages.on('click', function(event) {
            event.preventDefault();
			$linkedImages.dialog('close');

            var id = $(this).closest('#linkedImagesDialog').data('id');

            if (frame) {
                frame.open();
                return;
            }
            

            frame = wp.media({
                multiple: true  // Set to true to allow multiple files to be selected
            });

            frame.on('select', function() {

                var id = $('#linkedImagesDialog').data('id');
                var url;

                var attachments = frame.state().get('selection').toJSON();

                var $attachmentsContainer = $linkedImages.find('.linked-attachments-list .attachments-' + id);

                if (! $attachmentsContainer.length) {
                     $attachmentsContainer = $('<div class="attachments attachments-' + id + '" />').appendTo($linkedImages.find('.linked-attachments-list'));
                }

                for (var i = 0; i < attachments.length; i++) {
                    url = attachments[i].sizes.thumbnail && attachments[i].sizes.thumbnail.url ||
                        attachments[i].url;
                    $attachmentsContainer.append(
                        $imgTemplate.clone(true)
                            .find('.thumbnail')
                            .append($('<img />', {src: url})
                                .attr('data-attachment-id', attachments[i].id))
                            .end()
                    );
                }
				$linkedImages.dialog('open');
            });

            frame.open();
        });

        $removeImages.on('click', function() {
            var id = $(this).closest('#linkedImagesDialog').data('id');
            $('.linked-attachments-list .attachments-' + id + ' .sc-attachment.selected').fadeOut(300, function() { $(this).remove(); });
        });

        $('.selectLinkedImages').on('click', function(event) {
            event.preventDefault();
            var attachmentId = $(this).attr('data-id');
                $linkedImages.find('.attachments').hide();
            $linkedImages.find('.attachments-' + attachmentId).show();
            var $input = $('input[name="linkedImages"][data-id="' + attachmentId + '"]');

            var $attachmentsContainer = $linkedImages.find('.linked-attachments-list .attachments-' + attachmentId);

            if (! $attachmentsContainer.length) {
                $linkedImages.addClass('loading');
                $attachmentsContainer = $('<div class="attachments attachments-' + attachmentId + '" />').appendTo($linkedImages.find('.linked-attachments-list'));

                $linkedImages.dialog('open').data('id', attachmentId);

                $.ajax({
                    url: ajaxurl,
                    type: 'post',
                    data: {
                        'action': 'getAttachmentsById',
                        'attachments': $input.val()
                    },
                    success: function(response) {
                        $linkedImages.removeClass('loading');
                        var attachments = response.attachments;
                        for (var i = 0; i < attachments.length; i++) {
                            url = attachments[i].sizes.thumbnail && attachments[i].sizes.thumbnail.url ||
                                attachments[i].url;
                            $attachmentsContainer.append(
                                $imgTemplate.clone(true)
                                    .find('.thumbnail')
                                    .append($('<img />', {src: url}).attr('data-attachment-id', attachments[i].id))
                                    .end()
                            );
                        }

                        $linkedImages.find('.linked-attachments-list .attachments').sortable();
                    }
                });
            } else {
                $linkedImages.dialog('open').data('id', attachmentId);
            }
            
        });
    };

    Controller.prototype.initReplaceImage = function() {
        $('.replace-image').on('click',function(){
            var imageId = $(this).data('image-id'),
                attachmentId = $(this).data('attachment-id'),
                mediaSelect = wp.media(),
                $input = $('#replace_attachment_id_' + imageId),
                $form =  $('#photo-editor-' + imageId);

            mediaSelect.on('select', function() {
				var selection = mediaSelect.state().get('selection').toJSON();
				if(selection.length){
					SupsysticGallery.Loader.show('Replacing image');
					$input.val(selection[0].id);
					$form.unbind('submit');
					$form.submit(function (event) {
						event.preventDefault();
                        var $formCaption =  $('#photo-editor-caption-' + imageId),
                            $formSEO =  $('#photo-editor-seo-' + imageId),
                            $formHidden =  $('#photo-editor-hidden-' + imageId),
                            $formGallery =  $('#gallery-editor-hidden'),
                            data = '';
                        if($formCaption.length == 1) {
                            data = '&' + $formCaption.serialize();
                        }
                        if($formSEO.length == 1) {
                            data += '&' + $formSEO.serialize();
                        }
                        if($formHidden.length == 1) {
                            data += '&' + $formHidden.serialize();
                        }
                        if($formGallery.length == 1) {
                            data += '&' + $formGallery.serialize();
                        }
                        
                        $.post(ajaxurl, $(this).serialize() + '&_wpnonce=' + SupsysticGallery.nonce + data, function (response) {
							SupsysticGallery.Loader.hide();
							$.jGrowl('Information updated.'+response);
							window.location.reload();
						});
					});
					$form.trigger('submit');
				}
			});
            mediaSelect.open();
        });
    };

    Controller.prototype._initDialogs = function () {
        var GalleryDialog;
        var FolderDialog;
        var RenameDialog;
        var SelectDialog;

        var controller = this;

        GalleryDialog = new Dialog('#newGalleryDialog');
        GalleryDialog.button('Create', createNewGallery);
        GalleryDialog.button('Cancel', closeDialog);
        GalleryDialog.init();

        FolderDialog = new Dialog('#newFolderDialog');
        FolderDialog.button('Create', createNewFolder);
        FolderDialog.button('Cancel', closeDialog);
        FolderDialog.init();

        RenameDialog = new Dialog('#renameFolderDialog');
        RenameDialog.button('Rename', renameFolder);
        RenameDialog.button('Cancel', closeDialog);
        RenameDialog.init();

        SelectDialog = new Dialog('#selectGalleryDialog');
        SelectDialog.button('Add', addToGallery);
        SelectDialog.button('Cancel', closeDialog);
        SelectDialog.config.open = onSelectDialogOpen;
        SelectDialog.config.close = onSelectDialogClose;
        SelectDialog.init();

        this.initImportDialog();
        this.initEffectsDialog();
        this.initMetaDialog();
        this.initRenameCategoryDialog();
        this.initLinkedImagesDialog();
        this.initReplaceImage();

        //Open import dialog
        $('.import-to-gallery').on('click', function() {
            var galleryId = $(this).data('gallery-id'),
                dialog = controller.openImportDialog();
            if (dialog.children().hasClass('no-gallery-id')) {
                dialog.find('#gg-btn-upload').data('gallery-id', galleryId);
                dialog.find('a').each(function(index, el) {
                    var $this = $(this),
                        href = $this.attr('href').split('&');
                    href.splice(-1, 1, 'id=' + galleryId);
                    $this.attr('href', href.join('&'));
                });
            }
			// if it gallery list page
			galleryId = parseInt(galleryId);
			if(galleryId && !isNaN(galleryId)) {
				$('#videoUrlAddDialog').attr('data-gallery-id', galleryId);
			}
        });

        //Open caption effects dialog
        $('.selectCaptionEffectBtn').on('click', function(event) {
            event.preventDefault();
            var attachmentId = $(this).attr('data-id');
            var attach_sel = $(this).next().val();
            $('.grid-gallery-caption').removeClass('selected');
            $('[data-grid-gallery-type='+attach_sel+']').addClass('selected');
            controller.openEffectsDialog(attachmentId);
        });

		$('#effectDialog .grid-gallery-caption:not(.available-in-pro)').on('click', function() {
            var attachmentId = parseInt($(this).parents('#effectDialog').data('imgCaptionAttachmentId'));
            if(attachmentId) {
                $('.captionEffectVal[data-id="'+attachmentId+'"]').attr('value', $(this).attr('data-grid-gallery-type'));
                $("form.photo-editor.attachment-"+attachmentId+"").trigger('submit');
                $('#effectDialog').dialog('close').data('imgCaptionAttachmentId', 0);
            }
        });

        function addToGallery() {
            var $list = $('#galleryList');
            var post = app.Ajax.Post({
                module: 'galleries',
                action: 'attach'
            });

            var resources = [];
            $.each($('[data-observable]:checked'), function (index, checkbox) {
                var $entity = app.Common.getParentEntity($(checkbox));
                resources.push({ type: $entity.data('entity-type'), id: $entity.data('entity-id') })
            });

            app.Loader.show();

            post.add('gallery_id', $list.find(':selected').val());
            post.add('resources', resources);
            post.send($.proxy(function (response, request) {
                if (response.message) {
                    $.jGrowl(response.message);
                }

                this.dialog('close');
                app.Loader.hide();
            }, $(this)));
        }

        function closeDialog() {
            $(this).dialog('close');
        }

        function renameFolder() {
            var post = app.Ajax.Post({
                module: 'photos',
                action: 'updateTitle'
            });

            var $folder = app.Common.getParentEntity(observer.getChecked());
            var $form = $('#renameFolderForm');

            post.add('folder_name', $form.find('input#folderName').val());
            post.add('folder_id', $folder.data('entity-id'));

            post.send($.proxy(function (response, request) {
                if (!response.error) {
                    $folder.find('span.folder-title').text(request.folder_name);
                }

                if (response.message) {
                    $.jGrowl(response.message);
                }

                this.dialog('close');
            }, $(this)));
        }

        function createNewFolder() {
            var $container = $('[data-container]');
            var post = app.Ajax.Post({
                module: 'photos',
                action: 'addFolder'
            });

            post.add('folder_name', $('#folder-name').val());
            post.add('view_type', $container.data('container'));
            post.send($.proxy(function (response) {
                if (!response.error) {
                    $container.prepend(response.folder);
                    controller.init();
                    observer.reinit();
                }

                this.dialog('close');
            }, $(this)));
        }

        function createNewGallery() {
            var $form = $('#newGalleryForm');
            var post = app.Ajax.Post({
                module: 'galleries',
                action: 'create'
            });

            post.add('title', $form.find('input#galleryTitle').val());
            post.send($.proxy(function (gallery) {
                if (!gallery.error) {
                    var request = app.Ajax.Post({
                        module: 'galleries',
                        action: 'attach'
                    });

                    app.Loader.show();

                    var resources = [];
                    $.each($('[data-observable]:checked'), function (index, checkbox) {
                        var $entity = app.Common.getParentEntity($(checkbox));
                        resources.push({
                            id:   $entity.data('entity-id'),
                            type: $entity.data('entity-type')
                        })
                    });

                    request.add('gallery_id', gallery.id);
                    request.add('resources', resources);

                    request.send(function (response, request) {
                        $.jGrowl(response.message)
                    });

                    $.jGrowl(gallery.message);

                    this.dialog('close');
                    app.Loader.hide();
                }
            }, $(this)));
        }

        function onSelectDialogClose() {
            var $loader = $('#galleryLoading');
            var $form = $('#galleryForm');
            var $list = $('#galleryList');

            $list.html('');
            $loader.show();
            $form.hide();
        }

        function onSelectDialogOpen() {
            var post = app.Ajax.Post({
                module: 'galleries',
                action: 'list'
            });

            post.send(function (response) {
                if (response.galleries) {
                    var $list = $('#galleryList');
                    var $loader = $('#galleryLoading');
                    var $form = $('#galleryForm');

                    $.each(response.galleries, function (index, gallery) {
                        $list.append('<option value="' + gallery.id + '">' + gallery.title + '</option>');
                    });

                    $loader.hide();
                    $form.show();
                }
            });
        }
    };

    Controller.prototype.init = function () {
        // Initialize checkboxes hover effects on the "block view" pages.
        this._initCheckboxes();
        // Initialize colorbox plugin.
        this._initColorbox();
        // Initialize dialogs.
        this._initDialogs();

        //Submit form with param
        $('form.photo-editor').submit(function (event) {
            event.preventDefault();
            var $formHidden =  $('#photo-editor-hidden-' + $(this).data('id')),
                $formGallery =  $('#gallery-editor-hidden'),
                data = '';
            if($formHidden.length == 1) {
                data = '&' + $formHidden.serialize();
            }
            if($formGallery.length == 1) {
                data += '&' + $formGallery.serialize();
            }

            $.post(ajaxurl, $(this).serialize() + '&_wpnonce=' + SupsysticGallery.nonce + data, function (response) {
                $.jGrowl('Information updated.'+response);
            });
        });

        $('form.photo-editor textarea').on('keyup', function () {
            var $this = $(this);
            clearTimeout($this.data('timer'));
            $this.data('timer', setTimeout(function(){
                $this.removeData('timer');
                $this.parents('form.photo-editor').trigger('submit');
            }, 1500));
        });

        $('form.photo-editor input').on('keyup', function () {
            var $this = $(this);
            clearTimeout($this.data('timer'));
            $this.data('timer', setTimeout(function(){
                $this.removeData('timer');
                $this.parents('form.photo-editor').trigger('submit');
            }, 1500));
        });

        //Change checkbox option
        $('form.photo-editor input:checkbox').on('ifToggled', function(event) {
            $(this).parents('form.photo-editor').trigger('submit');
        });

        //Change select option
        $('form.photo-editor select[name]').on('change', function() {
            $(this).parents('form.photo-editor').trigger('submit');
        });

        observer.reinit();

        $('.gg-sort-entities').on('click', 'li', function (e) {
            if (e.altKey) {
                $(this).toggleClass('selected');
            } else if(e.shiftKey) {
                $(this).addClass('selected');
                var first = $(this).siblings('.selected').eq(0).index();
                if(first >= 0) {
                    $(this).siblings().removeClass('selected');
                    var current = $(this).index();
                        from = first < current ? first : current + 1,
                        to = first < current ? current - 1 : first,
                        $all = $(this).parent().find('li');
                    for(var i = from; i <= to; i++) {
                        $all.eq(i).addClass('selected');
                    }
                }
            } else {
                $(this).addClass('selected').siblings().removeClass('selected');
            }
        });

        $('.gg-all-container').sortable({
            connectWith: '.gg-all-container',
            delay: 150,
            revert: 0,
            opacity: 0.7,
            cursor: "move",
            cursorAt: { left: 30, top: 30 },
            helper: function (e, item) {
                var helper = $('<li/>');
                    if (!item.hasClass('selected')) {
                        item.addClass('selected').siblings().removeClass('selected');
                    }
                var elements = item.parent().children('.selected').clone();
                //item.data('multidrag', elements).siblings('.selected').remove();
                item.data('multidrag', elements).siblings('.selected').addClass('gg-hidden-entity');
                return helper.append(elements);
            },
            stop: function (e, li) {
                li.item.after(li.item.data('multidrag')).remove();
                $('.gg-hidden-entity').remove();
                $('div.gg-category').each(function() {
                    $(this).find('label[data-count]').html($(this).find('li').length);
                });
            }
        });

        $('.gg-category-container').sortable({
            connectWith: '.gg-category-container',
            delay: 150,
            revert: 0,
            opacity: 0.7,
            cursor: "move",
            cursorAt: { left: 30, top: 30 },
            helper: function (e, item) {
                var helper = $('<li/>');
                    if (!item.hasClass('selected')) {
                        item.addClass('selected').siblings().removeClass('selected');
                    }
                var elements = item.parent().children('.selected').clone();
                item.data('multidrag', elements).siblings('.selected').addClass('gg-hidden-entity');
                return helper.append(elements);
            },
            stop: function (e, li) {
                li.item.after(li.item.data('multidrag')).remove();
                $('.gg-hidden-entity').remove();
                $('div.gg-category').each(function() {
                    $(this).find('label[data-count]').html($(this).find('li').length);
                });
            },
            remove: function (e, li) {
                var ul = li.item.parent();
                ul.find('li').removeClass('selected');
                if(ul.is('[data-category]')) {
                    var newIndex = li.item.index(),
                        id = li.item.data('entity-id');
                    if(e.ctrlKey) {
                        li.item.clone().insertAfter(li.item);
                        $(this).sortable('cancel'); 
                        if(li.item.parent().data('category') == '') {
                            li.item.remove();
                        }                  
                    }
                    if(ul.data('category') == '') {
                        $('.gg-categories').find('li[data-entity-id="' + id + '"]').each(function() {
                            if($(this).parent().data('category') != '') {
                                $(this).remove();
                            }
                        });
                    }  
                    var copies = ul.find('li[data-entity-id="' + id + '"]'),
                        deleted = 0;
                    if(copies.length > 1) {
                        copies.each(function() {
                            if($(this).index() + deleted != newIndex) {
                                $(this).remove();
                                deleted++;
                            }
                        });
                    }
                }
                return li.item.clone();
            }
        });

        if($('.gg-categories').length) {
            $('.gg-categories').sortable({
                'axis': 'y',
                'handle': '.ggImgVerticalMove',
            });
        }

        //Change sorted images
        if($('[data-sortable]').length) {
            $('[data-sortable]').sortable({
                'axis': 'y',
                'handle': '.ggImgVerticalMove',
            });

            //Tablet and Phone fix touch
            $('[data-sortable] input').bind('click.sortable mousedown.sortable',function(ev){
                ev.target.focus();
            });

            $('[data-droppable]').droppable({
                hoverClass: 'folder-highlight',
                drop: function (event, ui) {

                    event.preventDefault();

                    var move = function ($entity, $folder) {

                        this.message = 'Unable to move photo to the selected folder';
                        this.request = app.Ajax.Post({
                            module: 'photos',
                            action: 'move'
                        });

                        this.request.add('folder_id', $folder.data('entity-id'));
                        this.request.add('photo_id', $entity.data('entity-id'));

                        this.request.send($.proxy(function (response) {
                            if (response.error) {
                                $.jGrowl(this.message);
                                return false;
                            }

                            var $counter = $folder.find('.gg-folder-photos-num');

                            $counter.text(function () {
                                return parseInt($counter.text(), 10) + 1;
                            });

                            $entity.remove();

                            return true;

                        }, this));

                    };

                    var
                    // dragged photo
                        $entity = ui.draggable,

                    // folder
                        $folder = $(this),

                    // photos container
                        $container = $entity.parents('[data-container]'),

                    // an array of the selected photos.
                        photos = [];

                    if ($('[data-observable]:checked').length > 0) {
                        $.each($('[data-observable]:checked'), function (index, checkbox) {
                            move(
                                app.Common.getParentEntity(checkbox),
                                $folder
                            );
                        });
                    } else {
                        move($entity, $folder);
                    }
                }
            });
        }
    };

    app.Controller = app.Controller || {};
    app.Controller.Photos = function () {
        return new Controller();
    }

}(window.SupsysticGallery = window.SupsysticGallery || {}, jQuery, ajaxurl));

jQuery(document).ready(function () {
    SupsysticGallery.Controller.Photos().init();

    jQuery('[data-upload]').ggPhotoUploader({
        wp: window.wp = window.wp || 'undefined'
    });
});
