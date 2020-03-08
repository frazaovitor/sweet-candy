/*global jQuery*/

(function (app, $) {

    function Controller() {
        this.isChecked = false;
        this.checked = [];
        this.galleryId = this.getParameterByName('gallery_id');
        this.$checkboxes = $('[data-observable]');

        this.init();
        this.allowRemove(false);
    }

    Controller.prototype.init = function () {
        this.$checkboxes.on('click', $.proxy(function (event) {

            var checked = false, checkboxes = [];

            $.each(this.$checkboxes, function (index, checkbox) {
                if (checkbox.checked) {
                    checked = true;
                    checkboxes.push(
                        app.Common.getParentEntity($(checkbox))
                    );
                }
            });

            this.isChecked = checked;
            this.checked = checkboxes;
            this.allowRemove(checked);

        }, this));
    };

    Controller.prototype.getParameterByName = function (name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");

        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    };

    Controller.prototype.allowRemove = function (state) {
        var $btn = $('[data-button="remove"]');

        $btn.attr('disabled', 'disabled');

        if (state) {
            $btn.removeAttr('disabled');
        }
    };

    Controller.prototype.filterImages = function() {
        var $imagesTr = $('#the-list').children('tr'),
            filterValue = $('#find-by-caption').val();

        $imagesTr.each(function(){
            var $captionField = $(this).find('textarea[name=caption]')
            if($captionField.val().indexOf(filterValue)!=-1
                || $(this).data('entity-info').attachment.title.indexOf(filterValue)!=-1
            ){
                $(this).show();
            }else{
                $(this).hide();
            }
        });
    };

    Controller.prototype.allImageTags = function (tag, type, images) {
        var ids = [],
            reload = true,
            post = app.Ajax.Post({
                module: 'galleries',
                action: 'allImageTags',
            }, { gallery_id: this.galleryId, type: type, tag: tag });

        if(!tag || tag == '') return false;
        if(typeof(images) != 'undefined' && images.length > 0) {
            ids = images;
            reload = false;
        } else {
            $.each(this.checked, function (index, $entity) {
                ids.push($entity.data('entity-id'));
            });
        }

        var deferred = $.Deferred();
        if(ids.length > 0){
            post.add('ids', ids);
            app.Loader.show('Update image category...');

            post.send(function (response) {
                $.jGrowl('Category updated.');
                app.Loader.hide();
                if(reload) {
                    location.reload(true);
                }
                deferred.resolve(response);
            });
            return deferred.promise();
        } else {
            $.jGrowl('Select images.');
        }
    }

    Controller.prototype.removePhoto = function (id) {
        if(!confirm($('#checkedDoLi').data('delete-confirm'))) return;

        var identifiers = [],
            entities = [],
            post = app.Ajax.Post({
                module: 'galleries',
                action: 'deleteResource'
            }, { gallery_id: this.galleryId });

        if(id) {
            identifiers.push(id);
            entities.push($('tr.ggImgInfoRow[data-entity-id="' + id + '"]'))
        } else {
            $.each(this.checked, function (index, $entity) {
                identifiers.push($entity.data('entity-id'));
                entities.push($entity);
            });
        }

        if(entities.length > 0){
            app.Loader.show('Deleting...');
            post.add('ids', identifiers);
            post.send(function (response) {
                if (!response.error) {
                    $.each(entities, function (index, $entity) {
                        $entity.remove();
                    });
                }
                app.PositionCtrl.updatePosition();

                $.jGrowl(response.message);
                // reload, if current page is not last
                var currentPage = parseInt($('#ggPaginationViewCurrPage').val(), 10)
                ,   perPage = parseInt($('#gg-pagination-per-page').val(), 10)
                ,   total = parseInt($('#ggPaginationViewTotal').val(), 10);
                if(!isNaN(currentPage) && !isNaN(perPage) && !isNaN(total)) {
                    var elementsAtLeastCount = total - perPage*currentPage;
                    if(elementsAtLeastCount > perPage) {
                        window.location.reload();
                    }
                }
                app.Loader.hide();
            });
        }
    };

    Controller.prototype.toggleCheckbox = (function (e) {
        //e.preventDefault();
        if (this.checked.length >= 0 && this.checked.length != this.$checkboxes.length) {
            this.$checkboxes.each($.proxy(function (index, element) {
                var $element = $(element);

                if (!$element.is(':checked')) {
                    $element
                        .trigger('click')
                        .attr('checked', 'checked')
                        .iCheck('update');
                }
            }, this));

            //$button.html('<i class="fa fa-fw fa-times"></i> Uncheck all');
        } else if (this.checked.length == this.$checkboxes.length) {
            this.$checkboxes.each($.proxy(function (index, element) {
                var $element = $(element);

                if ($element.is(':checked')) {
                    $element
                        .trigger('click')
                        .removeAttr('checked')
                        .iCheck('update');
                }
            }, this));
        }
    });

    Controller.prototype.handleEmptyImages = function () {
        var request = app.Ajax.Post({
            module: 'photos',
            action: 'isEmpty'
        }),
            controller = this,
            uploader;

        request.send(function (response) {
            if (!response.isEmpty) {
                return;
            }

            uploader = window.wp.media.frames.file_frame = window.wp.media({
                title:    'Choose images',
                button:   {
                    text: 'Choose images'
                },
                multiple: true
            });

            uploader.on('select', function () {
                var attachments = uploader.state().get('selection').toJSON(),
                    $container  = $('[data-container]'),
                    folderName  = $('#gg-breadcrumbs').find('a').last().text();

                this.request = app.Ajax.Post({
                    module: 'photos',
                    action: 'addFolder'
                });

                this.request.add('folder_name', folderName);
                this.request.add('view_type', $container.data('container'));
                this.request.send(function (response) {
                    var folderId = response.id;

                    if (response.error) {
                        $.jGrowl('Failed to create new folder ' + folderName);
                        return;
                    }

                    $.each(attachments, function (index, attachment) {
                        this.request = app.Ajax.Post({
                            module: 'photos',
                            action: 'add'
                        });

                        this.request.add('attachment_id', attachment.id);
                        this.request.add('folder_id', folderId);
                        this.request.add('view_type', $container.data('container'));

                        this.request.send(function (response) {
                            if (response.error) {
                                $.jGrowl('Failed to import images.');
                                return;
                            }

                            $.jGrowl(response.message);
                        });
                    });

                    this.request = app.Ajax.Post({
                        module: 'galleries',
                        action: 'attach'
                    });
                    this.request.add('gallery_id', controller.getParameterByName('gallery_id'));
                    this.request.add('resources', [{ type: 'folder', id: folderId }]);

                    this.request.send(function (response) {
                        if (!response.error) {
                            window.location.reload(true);
                        }

                        $.jGrowl(response.message);
                    });

                    return;
                });
            });

            $(document).ready(function () {
                $('#addImg').on('click', function (e) {
                    e.preventDefault();
                    uploader.open();
                });
            });
        });
    };

    Controller.prototype.sortBy = function(isTo) {
        var identifiers = [],
            sortby = $("[name=sortby]").find("option:selected"),
            sortTo = $("#sortToLi").find(".fa").hasClass('fa-arrow-up') ? 'asc' : 'desc';
        if(isTo) {
            sortTo = (sortTo == 'asc' ? 'desc' : 'asc');
        }
     
        var post = app.Ajax.Post({
            module: 'galleries',
            action: 'saveSortBy'
        }, { gallery_id: this.galleryId, sortby: sortby.val(), sortto: sortTo });

        app.Loader.show('Loading...');
        post.send(function (response) {
            app.Loader.hide();
            $.jGrowl(response.message);
            location.reload(true);
        });
    }

    Controller.prototype.copyImageTo = function(galleryId, isDelete, imageId) {    
        var ids = [];
            
        if(imageId) {
            ids.push(getAttachmentId(imageId));
        } else {
            $.each(this.checked, function (index, $entity) {
                ids.push($entity.data('entity-info').attachment_id);
            });
        }
        var reload = ids.length;
        if(!galleryId || reload == 0) return;

        var ajaxPromise = new $.Deferred().resolve(),
            controller = this;

        function copyImageAJAX(galleryId, attid) {
            var post = app.Ajax.Post({
                module: 'photos',
                action: 'add'
            }, {
                attachment_id: attid,
                galleryId: galleryId,
                view_type: 'list',
                attachType: 'gallery',
                save_exif_data: '1'
            });
            return post.send(function (response) {
                if (!response.error) {
                    if(!--reload) {
                        app.Loader.hide();
                        if(isDelete) {
                            controller.removePhoto(imageId);
                        }
                    }
                }
                $.jGrowl(response.message);
            });
        }

        $.each(ids, function (index, id) {
            ajaxPromise = ajaxPromise.then(function() {
                return copyImageAJAX(galleryId, id);
            });
        });
    }

    Controller.prototype.rotateImage = function(rotateType, imageId) {   
        var ids = [],
            post = app.Ajax.Post({
            module: 'photos',
            action: 'rotatePhoto'
        }, {
            rotateType: rotateType,
            gallery_id: this.galleryId
        });

        if(imageId) {
            ids.push(imageId);
        } else {
            $.each(this.checked, function (index, $entity) {
                ids.push($entity.data('entity-id'));
            });
        }
        if(ids.length == 0) return;

        post.add('ids', ids);

        app.Loader.show('Rotating...');
        post.send(function (response) {
            if (!response.error) {
                $.each(ids, function (index, id) {
                    reloadImage($('tr.ggImgInfoRow[data-entity-id="' + id + '"]').find('img.attachment-thumbnail'));
                });
                $.jGrowl(response.message);
            }
            app.Loader.hide();
        });
    }

    function reloadImage($img) {
        if($img.length) {
            $img.attr('src', $img.attr('src').split('?')[0] + '?' + Math.random());
            $img.data('original', $img.attr('src'));
        }
    }

    function getImageId(elem) {
        if(typeof(elem) == 'undefined') return false;

        var $elem = $(elem),
            $row = $elem.closest('tr');

        if($row.length) {
            return parseInt($row.data('entity-info').id, 10);
        }
        return false;
    }
    function getAttachmentId(id) {
        if(typeof(id) == 'undefined') return false;
        return parseInt($('tr.ggImgInfoRow[data-entity-id="' + id + '"]').data('entity-info').attachment_id, 10);
    }

    function setLinkActive(elem) {
        var $elem = $(elem),
            $div = $elem.closest('div.gg-image-option-links');
        if($div.length) {
            $div.find('.gg-option-links').removeClass('active');
        }
        $elem.addClass('active');
        $div = $elem.closest('tr').find('div.gg-option-containers');
        if($div.length) {
            $div.find('div.gg-option-container').addClass('ggSettingsDisplNone');
            $div.find('div.' + $elem.attr('href').substr(1) + '-option').removeClass('ggSettingsDisplNone');
        }
    }

    function viewCheckedContainer(action, attrName) {
        var $div = $('ul.gg-checked-options');
        $div.find('li.gg-checked-container').addClass('ggSettingsDisplNone');
        if(action == 'attributes') {
            var $container = $('#gg-attribute-values').empty();
            if(typeof(attrName) != 'undefined') {
                try {
                    var attrValues = JSON.parse($container.attr('data-values'));
                } catch(err) {
                    var attrValues = [];
                }
                var values = app.Controller.PhotosPro().getAtrributeValues(attrValues, attrName, 'values');
                if(values !== false) {
                   $.each(values, function(k, value) {
                        $container.append($('<option value="' + k + '"' + '>' + value + '</option>'));
                    });
                }
            }
        }
        $div.find('li.gg-checked-' + action).removeClass('ggSettingsDisplNone');
    }

    function viewCategoriesSort(show) {
        var $entityContainer = $('.gg-entities').find('ul'),
            $catContainers = $('.gg-category').find('ul');
        if(show) {
            $('[data-button="show-categories"]').addClass('ggSettingsDisplNone');
            $('[data-button="hide-categories"]').removeClass('ggSettingsDisplNone');
            $('.gg-entities').addClass('ggSettingsDisplNone');
            $('.gg-categories').removeClass('ggSettingsDisplNone');
            var $noCatContainer = false;
            $catContainers.empty();
            $catContainers.each(function(){
                var $this = $(this),
                    category = $this.attr('data-category');
                if(category == '') {
                    $noCatContainer = $this;
                } else {
                    $entityContainer.find('li[data-entity-tag *=";' + category + ';"]').removeClass('selected').clone().appendTo($this);
                }
                $this.closest('div.gg-category').find('label[data-count]').html($this.find('li').length);
            });
            if($noCatContainer != false) {
                $entityContainer.find('li[data-entity-tag !=";;"]').remove();
                $entityContainer.find('li').removeClass('selected').appendTo($noCatContainer);
                $noCatContainer.closest('div.gg-category').find('label[data-count]').html($noCatContainer.find('li').length);
            }
            $(window).trigger('resize');
        } else {
            $('[data-button="show-categories"]').removeClass('ggSettingsDisplNone');
            $('[data-button="hide-categories"]').addClass('ggSettingsDisplNone');
            $('.gg-entities').removeClass('ggSettingsDisplNone');
            $('.gg-categories').addClass('ggSettingsDisplNone');
            $entityContainer.empty();
            $catContainers.find('li').each(function(){
                var $this = $(this),
                    findEntity = $entityContainer.find('li[data-entity-id="' + $this.data('entity-id') + '"]'),
                    category = $this.parent().attr('data-category');
                if(findEntity.length > 0) {
                    var entity = findEntity.eq(0);
                    entity.attr('data-entity-tag', entity.attr('data-entity-tag') + category + ';');
                } else {
                    $this.attr('data-entity-tag', ';' + category + ';').removeClass('selected').appendTo($entityContainer);
                }
            });
        }
        $('.supsystic-container').css('height','');
    }

    function saveSortTags(controller) {
        if($('[data-button="show-categories"]').length == 0) return;

        var isShowCategory = $('[data-button="show-categories"]').hasClass('ggSettingsDisplNone'),
            ids = [],
            idsCategory = {};

        $('.gg-category').find('ul').each(function(){
            var category = $(this).data('category'),
                $entities = isShowCategory ? $(this).find('li') : $('.gg-entities').find('li[data-entity-tag *=";' + category + ';"]');
            if($entities.length > 0) {       
                var catIds = [],
                    id = 0;
                $entities.each(function(){
                    id = parseInt($(this).data('entity-id'), 10);
                    ids.push(id);
                    if(category != '') {
                        catIds.push(id);
                    }
                });
                idsCategory[category] = catIds;
            }
        });
        if(ids.length > 0) {
            $.when(controller.allImageTags('allcat', 'delcat', ids)).then(function(response) {
                $.each(idsCategory, function(tag, ids){
                    if(tag != '') {
                        controller.allImageTags(tag, 'add', ids);
                    }
                });
            });
        }
    }

    $(document).ready(function () {
        var queryString = new URI().query(true), controller;

        if (queryString.module === 'galleries'
            && (queryString.action === 'view' || queryString.action === 'addImages' || queryString.action === 'sort')
        ) {
            controller = new Controller();

            if(queryString.action === 'sort') {
                $('a[data-size-image]').on('click', function() {
                    var $this = $(this),
                        width = $this.data('width');
                    $this.siblings('a').removeClass('active');
                    $this.addClass('active');
                    $('.gg-image-thumbnail').attr('width', width).attr('height', width);
                    return false;
                });
                $('[data-button="show-categories"]').on('click', function() {
                    viewCategoriesSort(true);
                    return false;
                });
                $('[data-button="hide-categories"]').on('click', function() {
                    viewCategoriesSort(false);
                    return false;
                });
                $('[data-button="save-sort-order"]').on('click', function() {
                    app.PositionCtrl.updatePosition();
                    saveSortTags(controller);
                    return false;
                });
            }

            if(queryString.action === 'view') {
                $('a[href="#gg-delete"]').on('click', function() {
                    controller.removePhoto(getImageId(this));
                    return false;
                });
                $('a.option-link').on('click', function() {
                    setLinkActive(this);
                    return false;
                });
                $('[data-button="filterimages"]')
                    .on('click', $.proxy(controller.filterImages, controller));
                $('#find-by-caption').keyup(function(event){
                    controller.filterImages();
                });
                $('[name="checkedDo"]').on('change', function() {
                    $selected = $(this).find('option:selected');
                    viewCheckedContainer($selected.is('[data-attribute]') ? 'attributes' : $(this).val(), $selected.text());
                    return false;
                });
                $('[data-button="checkedbtn"]').on('click', function() {
                    var $action = $('[name="checkedDo"]');
                    if(!$action.length) return false;

                    var $selected = $action.find('option:selected');

                    if($selected.is('[data-attribute]')) {
                        var attrName = $selected.text(),
                            attrValue = $('#gg-attribute-values option:selected').text();

                        if(attrName.length > 0 && attrValue.length > 0) {
                            var data = [];
                            $.each(controller.checked, function (index, $entity) {
                                var $imgAttr = $entity.find('a.attributes-image'),
                                    attributes;

                                if($imgAttr.length > 0) {
                                    try {
                                        attributes = JSON.parse($imgAttr.attr('data-values'));
                                    } catch(err) {}
                                    if(!$.isArray(attributes)) {
                                        attributes = [];
                                    } 
                                    var attrIndex = app.Controller.PhotosPro().getAtrributeIndex(attributes, attrName);
                                    if(attrIndex === false) {
                                        attributes.push({name: attrName, value: attrValue});
                                    } else {
                                        attributes[attrIndex]['value'] = attrValue;
                                    }
                                    $imgAttr.attr('data-values', JSON.stringify(attributes));
                                    data.push({id: $entity.data('entity-id'), attributes: attributes});
                                }
                            });
                            app.Controller.PhotosPro().saveAttributes(data);
                        }
                        return;
                    }

                    switch($action.val()) {
                        case 'copy': 
                            controller.copyImageTo($('#gg-galleries-list').val(), false);
                            break;
                        case 'move': 
                            controller.copyImageTo($('#gg-galleries-list').val(), true);
                            break;
                        case 'rotate-clock': 
                            controller.rotateImage('clockwise');
                            break;
                        case 'rotate-cclock': 
                            controller.rotateImage('counter');
                            break;
                        case 'delete': 
                            controller.removePhoto();
                            break;
                        case 'crop': 
                            var position = $('#gg-crop-positions').val();
                            $.each(controller.checked, function (index, $entity) {
                                 $entity.find('select[name="cropPosition"]').val(position).trigger('change');
                            });
                            break;
                        case 'add-category': 
                            controller.allImageTags($('#gg-categories-list').val(), 'add');
                            break;
                        case 'del-category': 
                            controller.allImageTags($('#gg-categories-del').val(), 'delcat');
                            break;
                        case 'new-category': 
                            controller.allImageTags($('#gg-new-category').val(), 'add');
                            break;
                    }
                    return false;
                });

                var $galleriesList = $('#gg-galleries-list').find('option');
                if($galleriesList.length) {
                    $('select.copy-option').each(function(){
                        var $select = $(this);
                        $galleriesList.each(function(){
                            $select.append($(this)[0].outerHTML);
                        });
                    });
                    $('.image-copy-btn, .image-move-btn').on('click', function() {
                        var $elem = $(this);
                        controller.copyImageTo(
                            $elem.parent().find('select.copy-option').val(),
                            $elem.hasClass('image-move-btn'),
                            getImageId($elem)
                        );
                        return false;
                    });
                } else {
                    $('.image-copy-btn').attr('disabled', 'disabled');
                    $('.image-move-btn').attr('disabled', 'disabled');
                }

                $('.image-rotate-btn').on('click', function() {
                    controller.rotateImage($(this).parent().find('select.rotate-option').val(), getImageId($(this)));
                    return false;
                });  
            }

            $('input#checkAll')
                .on('click', $.proxy(controller.toggleCheckbox, controller));

            $('[data-button="sortbtn"]').on('click', function() {
                controller.sortBy(true);
            });

            $('select[name="sortby"]').on('change', function() {
                var $sortTo = $("#sortToLi");
                if($('select[name="sortby"] option:selected').text() === 'Randomly') {
                    $sortTo.hide();
                } else {
                    $sortTo.show();
                }
                controller.sortBy(false);
            });

            controller.handleEmptyImages();
        }
    });

}(window.SupsysticGallery = window.SupsysticGallery || {}, jQuery));
