function sggDataSelectorsCache() {
	this.keys = {};
	this.values = {};
}

sggDataSelectorsCache.prototype.init = (function(params) {
	if(params) {
		if(params['keys']) {
			jQuery.extend(this.keys, params['keys']);
		}
		if(params['values']) {
			jQuery.extend(this.values, params['values']);
		}
	}
});

sggDataSelectorsCache.prototype.get = (function(key) {
	if(this.keys[key]) {
		if(!this.values[key]) {
			// if its not a "selector" string
			if(!this.keys[key].length) {
				return null;
			}
			this.values[key] = jQuery(this.keys[key]);
		}
		return this.values[key];
	}
	return null;
});

sggDataSelectorsCache.prototype.getFromArray = (function(key) {
	var currItemSelector = this.keys
		,	ksIndex = 0
		,	fullKeyStr = null;
	;

	if(!key || !key.join || !currItemSelector) {
		return null;
	}
	fullKeyStr = key.join('.');

	if(this.values[fullKeyStr]) {
		return this.values[fullKeyStr];
	}
	// check if key exist in this.index Object
	while(ksIndex < key.length && currItemSelector) {
		if(currItemSelector[key[ksIndex]]) {
			currItemSelector = currItemSelector[key[ksIndex]]
		} else {
			currItemSelector = null;
		}
		ksIndex++;
	}
	//
	if(currItemSelector && ksIndex == key.length) {
		// if its not a "selector" string
		if(!currItemSelector.length) {
			return null;
		}

		this.values[fullKeyStr] = jQuery(currItemSelector);
		return this.values[fullKeyStr];
	}
	//
	return null;
});

/*global jQuery*/
(function (app, $) {

	app.hexToRgb = (function(hex) {
		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return result ? {
			r: parseInt(result[1], 16),
			g: parseInt(result[2], 16),
			b: parseInt(result[3], 16),
		} : null;
	});

    function Controller() {
        this.$container = $('.form-tabs');
        this.tabs = this.getAvailableTabs();
        this.$currentTab = null;
        this.$currentTarget = null;
        this.linksOyPositions = [];

        this.strToBool = function(value) {
            if(value == 'true') {
                return true;
            } else {
                return false;
            }
        }

        this.init();
    }

    Controller.prototype.init = function () {
        var lastTab = this.getCookie('lastTab');

        if (!lastTab) {
            this.$currentTab = this.tabs[Object.keys(this.tabs)[0]];
            this.$currentTarget = $('.change-tab').first();
        } else {
            this.$currentTarget = $('.change-tab[href="' + lastTab + '"]');
            this.$currentTab = $('[data-tab="' + lastTab + '"]');
        }

        this.hideTabs();
        this.$currentTab.fadeIn();
        this.$currentTarget.addClass('active');
    };

    Controller.prototype.getParameterByName = function (name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");

        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    };

    Controller.prototype.getCookie = function (name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : null;
    };

    Controller.prototype.setCookie = function (name, value) {
        document.cookie = name + '=' + encodeURIComponent(value);
    }

    Controller.prototype.getAvailableTabs = function () {
        var tabs = {};

        $.each($('[data-tab]'), function (index, tab) {
            tabs[$(tab).data('tab')] = $(tab);
        });

        return tabs;
    };

    Controller.prototype.hideTabs = function () {
        $.each(this.tabs, function () { this.hide() });
    };

    Controller.prototype.changeTab = function (event) {
        event.preventDefault();

        this.hideTabs();

        this.$currentTarget.removeClass('active');

        this.$currentTarget = $(event.currentTarget);
        this.$currentTarget.addClass('active');

        this.$currentTab = this.tabs[this.$currentTarget.attr('href')];
        this.$currentTab.show();

        this.setCookie('lastTab', this.$currentTarget.attr('href'));
    };

    Controller.prototype.remove = function (event) {
        if (!confirm('Are you sure?')) {
            event.preventDefault();
        }
    };

    Controller.prototype.saveButton = function() {
		var selfC = this;
        $('#btnSave').on('click', function() {
			selfC.saveScrollPos();
            document.forms['form-settings'].submit();
        });
    }

	Controller.prototype.saveScrollPos = (function() {
		var scrollTopPos = parseInt($('.settings-wrap').scrollTop());
		if(!isNaN(scrollTopPos)) {
			$('#slimScrollStartPos').val(scrollTopPos);
		}
	});

    Controller.prototype.setInputColor = (function() {
        $('input[type="color"]').each(function() {
            if(navigator.userAgent.match(/Trident\/7\./)) {
                $(this).css('background-color', $(this).val());
            }
        });
    });

    // ICONS
    Controller.prototype.initIconsDialog = function () {

        var $dialog = $('#iconsPreview').dialog({
            autoOpen: false,
            buttons:  {
                Cancel: function () {
                    $(this).dialog('close');
                }
            },
            modal:    true,
            width:    645
        });

        $('#selectIconsEffect').on('click', function(event) {
            event.preventDefault();
            $dialog.dialog('open');
        });

        $('#iconsPreview .hi-icon').on('click', function(event) {
            event.preventDefault();
            var effectName = $(event.currentTarget).data('effect')
			,	baseEffectName = $(event.currentTarget).data('effect-base')
			,	$previewIcons = $('#preview .sggCbEntrySpan.hi-icon-wrap')
			,	prevEffectName = $('#iconsEffectName').val()
			,	prevBaseEffectName = prevEffectName.substr(0, prevEffectName.length - 1)
			;

            $dialog.dialog('close');
            $('#iconsEffectNameText').text(effectName);
			$previewIcons.removeClass(prevEffectName).removeClass(prevBaseEffectName);
			$('#iconsEffectName').val(effectName)
				.trigger('change');
			$previewIcons.addClass(effectName).addClass(baseEffectName);
        });

        $('#sggFewIconsShowingRow').find('[data-disabled="disabled"]').each(function() {
            var checkbox = $(this),
                checkboxId = checkbox.attr('id');
            checkbox.prop('checked',false).css({'pointer-events':'none'}).parent().css({'pointer-events':'none'}).prop('disabled',true);
            $('[for="'+ checkboxId+ '"]').css({'pointer-events':'none'}).prop('disabled',true);
        });

        // $('#iconsOverlay').on('change', $.proxy(Ctrl.toggleOverlay, Ctrl)).trigger('change');
    };

    Controller.prototype.toggleSlideShow = function () {
        var $options = $('[name="box[slideshowSpeed]"], [name="box[slideshowAuto]"], [name="box[popupHoverStop]"]'),
            $slideshow = $('[name="box[slideshow]"]');

        if($slideshow.val() == 'true'){
            $options.parents('tr').show();
        } else {
            $options.parents('tr').hide();
        }

        $slideshow.on('change', function(){
            if($(this).val() == 'true') {
                $options.parents('tr').show();
            } else {
                $options.parents('tr').hide();
            }
        })
    };

    Controller.prototype.togglePopupTheme = function (value) {
        var $boxType = $('[name="box[type]"]');

        $boxType.attr('value', '0');

        if(value == 'theme_6') {
            $boxType.attr('value', '1');
        }
        if(value == 'theme_1_pro') {
            $boxType.attr('value', '2');
        }
    };

    Controller.prototype.removePresetRequest = function () {
        var presetId = $('#presetId').val(),
            request = app.Ajax.Post({
                module: 'galleries',
                action: 'removePreset'
        });

        request.add('preset_id', presetId);

        return request;
    };

    Controller.prototype.initSaveDialog = function () {
        $('#saveDialog').dialog({
            width:    350,
            autoOpen: false,
            modal:    true,
            buttons:  {
                Save:   function () {
                    var $settingsId  = $('#settingsId'),
                        $presetTitle = $('#presetTitle'),
                        request = app.Ajax.Post(
                            {
                                module: 'galleries',
                                action: 'savePreset'
                            }
                        );

                    // Close the dialog and show error if the settings isn't yet saved to the database.
                    if ($settingsId.val() === 'undefined') {
                        $.jGrowl('You must to save the settings first.');
                        $(this).dialog('close');
                    }

                    request.add('settings_id', $settingsId.val());
                    request.add('title', $presetTitle.val());

                    request.send($.proxy(function (response) {
                        if (response.message) {
                            $.jGrowl(response.message);
                        }

                        if (!response.error) {
                            window.location.reload(true);
                        }

                        $(this).dialog('close');
                    }, this));
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
    };

    Controller.prototype.openSaveDialog = function () {
        $('#saveDialog').dialog('open');
    };

    Controller.prototype.initDeleteDialog = function () {
        var controller = this;

        $('#deletePreset').dialog({
            width:    350,
            autoOpen: false,
            modal:    true,
            buttons:  {
                Delete: function () {
                    var request = controller.removePresetRequest();

                    request.send($.proxy(function (response) {
                        if (response.message) {
                            $.jGrowl(response.message);
                        }

                        if (!response.error) {
                            window.location.reload(true);
                        }

                        $(this).dialog('close');
                    }, this));
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
    };

    Controller.prototype.openDeleteDialog = function () {
        $('#deletePreset').dialog('open');
    };

    Controller.prototype.initLoadDialog = function () {
        var controller = this;

        $("#loadPreset").dialog({
            width:    350,
            autoOpen: false,
            modal:    true,
            buttons:  {
                Cancel: function () {
                    $(this).dialog('close');
                },
                Load: function () {
                    var galleryId,
                        presetId,
                        $presetsList = $('#presetList'),
                        request = app.Ajax.Post({
                            module: 'galleries',
                            action: 'applyPreset'
                        });

                    // Get gallery Id from the browser's query string.
                    galleryId = parseInt(controller.getParameterByName('gallery_id'), 10);

                    // Get preset id from the preset list.
                    presetId = parseInt($presetsList.val(), 10);

                    request.add('gallery_id', galleryId);
                    request.add('preset_id', presetId);

                    request.send($.proxy(function (response) {
                        if (response.message) {
                            $.jGrowl(response.message);
                        }

                        if (!response.error) {
                            $(this).dialog('close');
                            window.location.reload(true);
                        }
                    }, this));
                }
            },
            open: function () {
                var request = app.Ajax.Post({
                    module: 'galleries',
                    action: 'getPresetList'
                });

                request.send(function (response) {
                    var $presetList = $('#presetList'),
                        $errors = $('#presetListError');

                    if (response.error) {
                        $presetList.attr('disabled', 'disabled');
                        $errors.find('#presetLoadingFailed').show();
                        return;
                    }

                    if (response.presets.length < 0) {
                        $presetList.attr('disabled', 'disabled');
                        $errors.find('#presetEmpty').show();
                        return;
                    }

                    $.each(response.presets, function (index, preset) {
                        $presetList.append('<option value="'+preset.id+'">'+preset.title+'</option>');
                    });
                });
            }
        });
    };

    Controller.prototype.openPresetDialog = function () {
        $('#loadPreset').dialog('open');
    };

    Controller.prototype.removePresetFromList = function () {
        var request = this.removePresetRequest();

        request.send(function (response) {
            if (response.error) {
                return false;
            }

            $('#presetId').find(':selected').remove();
        });
    };

    Controller.prototype.initNoticeDialog = function() {
        $('#reviewNotice').dialog({
            modal:    true,
            width:    600,
            autoOpen: true
        });
    };

    Controller.prototype.showReviewNotice = function() {
        var self = this;

        $.post(window.wp.ajax.settings.url,
            {
                action: 'grid-gallery',
                _wpnonce: SupsysticGallery.nonce,
                route: {
                    module: 'galleries',
                    action: 'checkReviewNotice'
                }
            })
            .success(function (response) {

                if(response.show) {
                    self.initNoticeDialog();

                    $.merge($('#reviewNotice [data-statistic-code]').closest('button'),
                        $('#reviewNotice').prev().find('button')).on('click', function() {

                        $.post(window.wp.ajax.settings.url, {
                                action: 'grid-gallery',
                                _wpnonce: SupsysticGallery.nonce,
                                route: {
                                    module: 'galleries',
                                    action: 'checkNoticeButton'
                                }
                            })
                            .success(function(response) {
                                $('#reviewNotice').dialog('close');
                            });
                    });
                }
            });
    };

    Controller.prototype.initThemeDialog = function () {
    	var self2 = this;
        $('#themeDialog').dialog({
            autoOpen: false,
            modal:    true,
            width:    570,
            buttons:  {
                // Select: function () {
                //     var selected = $('#bigImageThemeSelect').val(),
                //         $theme = $('#bigImageTheme');
                //
                //     $theme.val(selected);
                //     $(this).dialog('close');
                // },
				'Ok': function(event) {
					var themeCode = $('#bigImageTheme').val()
					,	$hiddenPopupPlacementType = $('#popupPlacementTypeHidden')
					,	currentPptValue = $('.popupPlacementTypeRadio:checked').val()

					if(themeCode == 'theme_7' || themeCode == 'theme_5' || themeCode == 'theme_4' || themeCode == 'theme_3' || themeCode == 'theme_2' || themeCode == 'theme_1') {
						$hiddenPopupPlacementType.val(currentPptValue);
					} else {
						$hiddenPopupPlacementType.val(0);
					}
					self2.callExtenedFunc('popupThemeChanged', themeCode);
					$(this).dialog('close');
                },
                // Cancel: function () {
                //     // revert all prev settings
                //     $(this).dialog('close');
                // }
            },
			'open': function(event, ui) {
				self2.changeThemeDialogFitImageVisibility();
			},
        });

        Controller.prototype.changeThemeDialogFitImageVisibility = (function(event) {
			var $pptWrapper = $('.popupPlacementTypeWrapper')
			,	themeCode = $('#bigImageTheme').val();
			if(themeCode == 'theme_7' || themeCode == 'theme_5' || themeCode == 'theme_4' || themeCode == 'theme_3' || themeCode == 'theme_2' || themeCode == 'theme_1') {
				$pptWrapper.removeClass('ggSettingsDisplNone');
			} else {
				$pptWrapper.addClass('ggSettingsDisplNone');
			}
		});

        Controller.prototype.initThemeSelect = function () {
            var $theme = $('#bigImageTheme'),
                self = this;

            $('.theme').on('click', function () {
				var $this = $(this)
				,	themeCode = $this.data('val');
				$('#themeDialog .grid-gallery-caption').removeClass('gg-active');
				$this.parent().addClass('gg-active');
				$theme.val(themeCode);
				$('.themeName').text($this.data('name'));
				self.togglePopupTheme($this.data('val'));
				// change visibility for placement wrapper
				self.changeThemeDialogFitImageVisibility();
            });
        };

		Controller.prototype.dialogOpenEvent = (function( self, event, ui ) {

			var $elementsWithEffects = $('#effectDialog .grid-gallery-caption:not(.available-in-pro)')
			,	$previewElement = $('#preview .grid-gallery-caption')
			,	$previewFigcaption = $previewElement.find('figcaption');

			if($previewFigcaption.length) {
                var cssProperties = {};
                cssProperties['background-color'] = $previewFigcaption.css('background-color');
				if($('.ggUserCaptionBuilderCl:checked').val() == '1') {
                    cssProperties['top'] = 0;
                    cssProperties['bottom'] = 0;
                }
				$.each($elementsWithEffects, function( i, val ) {
					if($('.ggUserCaptionBuilderCl:checked') == '1' && $(val).data('gridGalleryType') == 'center') {
						cssProperties['transform'] = 'none';
					} else {
						delete cssProperties['transform'];
					}
					$(val).find('figcaption').css(cssProperties);
				});
			}
			// once init some effects
			if(!self.captionEffectForDialogIsInit) {
				self.captionCubeEffectInit($('#effectDialog .grid-gallery-caption[data-grid-gallery-type="cube"]'));
				self.captionEffectForDialogIsInit = true;
			}
		});

		Controller.prototype.captionCubeEffectInit = (function($currElem) {
			function checkDirection($element, e) {
				var w = $element.width(),
					h = $element.height(),
					x = ( e.pageX - $element.offset().left - ( w / 2 )) * ( w > h ? ( h / w ) : 1 ),
					y = ( e.pageY - $element.offset().top - ( h / 2 )) * ( h > w ? ( w / h ) : 1 );

				return Math.round(( ( ( Math.atan2(y, x) * (180 / Math.PI) ) + 180 ) / 90 ) + 3) % 4;
			}
			$currElem.on('mouseenter mouseleave', function(e) {
				var $figcaption = $currElem.find('figcaption'),
					direction = checkDirection($currElem, e),
					classHelper = null;

				switch (direction) {
					case 0:
						classHelper = 'cube-' + (e.type == 'mouseenter' ? 'in' : 'out') + '-top';
						break;
					case 1:
						classHelper = 'cube-' + (e.type == 'mouseenter' ? 'in' : 'out') + '-right';
						break;
					case 2:
						classHelper = 'cube-' + (e.type == 'mouseenter' ? 'in' : 'out') + '-bottom';
						break;
					case 3:
						classHelper = 'cube-' + (e.type == 'mouseenter' ? 'in' : 'out') + '-left';
						break;
				}
				$figcaption.removeClass()
					.addClass(classHelper);
			});
		});

        Controller.prototype.initEffectsDialog = function () {
			var self = this;
            $('#effectDialog').dialog({
                autoOpen: false,
                modal:    true,
                width:    740,
                'open': function( event, ui ) {
					self.dialogOpenEvent(self, event, ui);
				},
                buttons:  {
                    Cancel: function () {
                        $(this).dialog('close');
                    }
                }
            });
        };

        Controller.prototype.openEffectsDialog = function () {
            $('#effectDialog').dialog('open');
        };
    };

    Controller.prototype.setScroll = function() {
        var $settingsWrap = $('.settings-wrap');

        $settingsWrap.slimScroll({
            height: '600px',
            railVisible: true,
            alwaysVisible: true,
            allowPageScroll: true
        });
        var $preview = $('#preview.gallery-preview').css({
            'opacity': 1,
        }).hide();
        $settingsWrap.fadeIn();
        $preview.fadeIn();
    };

    Controller.prototype.initEffectPreview = function () {
        var $effect  = $('#overlayEffect'),
            $preview = $('#effectsPreview'),
            $dialog  = $('#effectDialog');

        $preview.find('figure:not(.available-in-pro)').on('click', function (event) {
            event.preventDefault();
			var $this = $(this);

            $preview.find('figure').removeClass('selected');
			$this.addClass('selected');

            if ($this.data('type') == 'icons') {
                if (!confirm($this.parent().data('confirm'))) {
                    return;
                }
				if($('.grid-gallery-caption[data-caption-buider="1"]').data('caption-buider') == '1') {
					if(!$("#captionBuilderIconsEnable:checked").length) {
						$("#captionBuilderIconsEnable").trigger('click').iCheck('toggle');
					}
				} else {
					$('#icons-enable').iCheck('toggle').trigger('change');
				}
            }

            $('.selectedEffectName').text($.proxy(function () {
                return this.find('span').text();
            }, $this));

            $('#preview [data-grid-gallery-type]')
                .data('grid-gallery-type', $this.data('grid-gallery-type'));

			$effect.val($this.data('grid-gallery-type'));
            $('#preview.gallery-preview').trigger('preview.refresh');

            if ($this.data('grid-gallery-type') == 'polaroid') {
                $('.polaroid-effect-class:enabled').val('true').trigger('change');
            }
			// check pro effects
			if(app && app.ImagePreview && app.ImagePreview.initImageOnHoverEffectHandler) {
				app.ImagePreview.initImageOnHoverEffectHandler($this.data('grid-gallery-type'));
			}
            
            $dialog.dialog('close');
        });
        $preview.find('[data-grid-gallery-type="' + $effect.val() + '"]').addClass('selected');
    };

    Controller.prototype.openThemeDialog = function () {
        $('#themeDialog').dialog('open');
    };

    Controller.prototype.toggleArea = function() {
        var $toggle = $('[name="area[grid]"]'),
			selfContr = this,
            $optionsHeight = $('[name="area[photo_height]"]'),
            $optionsHeightRow = $optionsHeight.closest('tr'),
            $optionsWidth = $('[name="area[photo_width]"]'),
            $optionsWidthRow = $optionsWidth.closest('tr'),
            $columsRow = $('#generalColumnsRow'),
            $responsiveColumnsRow = $('#responsive-columns').closest('tr'),
			$ggImageWidthUnit = $('[name="area[photo_width_unit]"]'),
			$ggImageHeightUnit = $('[name="area[photo_height_unit]"]'),
            $mosaicImagesCountRow = $('#mosaic-images-count-row');

		var $loadMoreContent = $('#gg-anl-load-more'),
            $afterLoadMoreContentSeparator = $('#gg-anl-load-more').next('.separator').first(),
            $inputShowMore = $('#show-more-disable').closest('.iradio_minimal'),
			$mosaicLayout = $('#sggMosaicLayout'),
            $mosaicCountColumnsRow = $('#sggMosaicCountColumnsRow'),
			$sggLazyLoadEnableRow = $('#sggLazyLoadEnableRow'),
			$mosaicImageCountTextWr = $('#gg-mosaic-image-count-text-wrapper'),
            $imageCountWrapper = $('#gg-mosaic-image-count-wrapper');

		$mosaicImageCountTextWr.show();
		function mosaicLayoutToggle() {
			if($toggle.find('option:selected').val() == 4) {
                if($mosaicLayout.find('option:selected').val() == 1) {
					// Disable LazyLoad Option
					$('#lazyLoadDisabled').iCheck('check');
                    $mosaicCountColumnsRow.show();
					$sggLazyLoadEnableRow.hide();
					//
					$mosaicImageCountTextWr.hide();
					$imageCountWrapper.hide();
					$('#mosaicDisplayAllImg').iCheck('uncheck');
					$('#mosaicShowHiddenImages').iCheck('uncheck');
					$('#mosaic-show-hidden-images-row').removeClass('ggSettingsDisplNone');
					$('#mosaic-display-all-images-row').removeClass('ggSettingsDisplNone');
					//Show load more button and sections
					$loadMoreContent.show();
					$afterLoadMoreContentSeparator.show();
				} else {
                    $mosaicCountColumnsRow.hide();
					$sggLazyLoadEnableRow.show();
					$mosaicImageCountTextWr.show();
					$imageCountWrapper.show();
					$loadMoreContent.hide();
					$afterLoadMoreContentSeparator.hide();
				}
			} else {
				$sggLazyLoadEnableRow.show();
				$mosaicImageCountTextWr.hide();
				$imageCountWrapper.hide();
				//Show load more button and sections
				$loadMoreContent.show();
				$afterLoadMoreContentSeparator.show();
			}

			selfContr.slimScrollOnSizeEvent(selfContr);
		}
		$mosaicLayout.on('change', mosaicLayoutToggle);

        $toggle.on('change', function() {

            $optionsWidthRow.find('input, select').prop('disabled', false);
            $optionsHeightRow.find('input, select').prop('disabled', false);
            $optionsWidthRow.show();
            $optionsHeightRow.show();
            $columsRow.hide();
            $mosaicImagesCountRow.hide();
            $responsiveColumnsRow.hide();

            if (!$optionsHeight.val().length) {
                $optionsHeight.val($optionsWidth.val());
            }

            if (!$optionsWidth.val().length) {
                $optionsWidth.val($optionsHeight.val());
            }

			// hide all others mosaic settings
			var selectedTypeVal = $(this).find('option:selected').val()
			,	$mosaicLayoutRow = $('#sggMosaicLayoutRow')
            ,   $mosaicCountColumnsRow = $('#sggMosaicCountColumnsRow')
			,	$alwaysShowObj = $('#display-first-photo-row');
			$mosaicLayoutRow.hide();
            $mosaicCountColumnsRow.hide();
			$alwaysShowObj.show();
            var $pagesRow = $('#usePages');
            
			switch(selectedTypeVal) {
                // Fixed
                case '0':
                    $optionsWidthRow.find('option[name="percents"]').hide();
                    $optionsHeightRow.find('option[name="percents"]').hide();
                    break;
                // Vertical
                case '1':
                    if($pagesRow.find('#showPages').prop('checked')) {
                        $pagesRow.find('#hidePages').prop('checked', true).trigger('change');
                        $.jGrowl('Pagination disabled now');
                    }
                    $optionsHeightRow.hide();
                    $optionsHeightRow.find('input, select').prop('disabled', true);
                    $optionsWidthRow.find('option[name="percents"]').show();
                    break;
                // Horizontal
                case '2':
                    $optionsWidthRow.hide();
                    $optionsHeightRow.find('option[name="percents"]').show();
                    $optionsWidthRow.find('input, select').prop('disabled', true);
                    break;
                // Fixed columns
                case '3':
                    $columsRow.show();
                    $responsiveColumnsRow.show();
                    $optionsWidthRow.find('option[name="percents"]').hide();
                    $optionsHeightRow.find('option[name="percents"]').hide();
                    break;
				// Mosaic
				case '4':
					// Strict use of images order
					$mosaicLayoutRow.show();
                    $mosaicCountColumnsRow.show();
					$optionsHeightRow.hide();
					$optionsHeightRow.find('input, select').prop('disabled', true);
					$optionsWidthRow.find('option[name="percents"]').show();
					$alwaysShowObj.hide();
					$mosaicImagesCountRow.show();
					break;
            }
            $pagesRow.find('input[name="pagination[enabled]"]').prop('disabled', selectedTypeVal == 1).iCheck('update');
			mosaicLayoutToggle();

			if(selectedTypeVal != 1) {
				// reset values
				$ggImageWidthUnit.val(0);
				$ggImageHeightUnit.val(0);
			}
        }).trigger('change');
    };

    Controller.prototype.toggleShadow = function () {
        var $shadowTable = $('[name="shadow"]'),
            value = 0;

        $('#showShadow').on('click', function () {
            $shadowTable.find('tbody').show();
        });

        $('#hideShadow').on('click', function () {
            $('#useMouseOverShadow').attr('value', 0);
            $('select[name="thumbnail[shadow][overlay]"]').attr('value', 0).trigger('change');
            $shadowTable.find('tbody').hide();
        });

        $shadowTable.find('thead input[type="radio"]:checked')
            .trigger('click')
            .trigger('change');
    };

    Controller.prototype.toggleBorder = function () {
        var $table = $('table[name="border"]'),
            $borderType =$('select[name="thumbnail[border][type]"]'),
            $toggleRow = $borderType.closest('tr'),
            value = 0;

        value = parseInt($toggleRow.val(), 10);

        $borderType.on('change', function () {
            if($(this).find('option:selected').val() != 'none') {
                $table.find('tr').show();
            } else {
                $table.find('tr').hide();
                $toggleRow.show();
            }
        });

        $borderType.on('change', function() {
            $table.find('[name="border-type"]').css('border-style', $(this).find('option:selected').val());
        });
    };

    Controller.prototype.toggleCaptions = function () {
        var $table = $('table[name="captions"] thead'),
            $toggleRow = $('#useCaptions'),
            value = 0;

        value = this.strToBool($('[name="thumbnail[overlay][enabled]"]:checked').val());

        $('#hideCaptions').on('change', function () {
            $table.find('tr').hide();
            $toggleRow.show();
        }).trigger('change');

        $('#showCaptions').on('change', function () {
            $table.find('tr').show();
        }).trigger('change');

        if(value) {
            $table.find('tr').show();
        } else {
            $table.find('tr').hide();
            $toggleRow.show();
        }
    };

    Controller.prototype.areaNotifications = function () {
        var $photoWidth = $('input[name= "area[photo_width]"]'),
            $photoHeight = $('input[name= "area[photo_height]"]'),
			isPostFeedEnabled = $('.ggPostsEnableCl:checked').val() == 1,
            $overlay = $('[name="thumbnail[overlay][enabled]"], [name="icons[enabled]"]'),
            self = this;

        $photoWidth.on('change' , function() {
			if($photoWidth.val() < 240 && isPostFeedEnabled) {
                $.jGrowl('Low image width \n post feed content can be too small');
            }

            if($photoWidth.val() == 'auto') {
                $.jGrowl('Use image original width');
            }
        });

        $photoHeight.on('change', function() {
			if($photoHeight.val() < 240 && isPostFeedEnabled) {
                $.jGrowl('Low image height \n post feed content can be too small');
            }

            if($photoHeight.val() == 'auto') {
                $.jGrowl('Use image original height');
            }
        });

        $overlay.on('change', function(event) {
            var $overlayChecked = $('[name="thumbnail[overlay][enabled]"]:checked, [name="icons[enabled]"]:checked'),
                showNotification = true;

            $.each($overlayChecked, function(index, value) {
                if(!self.strToBool($(value).val()) || !this.length) {
                    showNotification = false;
                }
            });


            if(showNotification) {
                $.jGrowl("Caption animation effect is disabled now, turn off icons to use it");
            }
        });
    }

    Controller.prototype.togglePostsTable = (function() {
        var $navButtons = $('.form-tabs'),
			$prePostTableControls = $('.sggPostsPreTable'),
            $table = $('#gbox_ui-jqgrid-htable');

        $navButtons.on('click', function() {
			var currHref = $(this).find('a.active').attr('href');
			if(currHref == 'post') {
                $table.show();
				$prePostTableControls.show();
            } else {
				$table.hide();
				$prePostTableControls.hide();
            }
			if(currHref == 'area') {
				$('.gg-wraper-anchor-nav-links').show();
			} else {
				$('.gg-wraper-anchor-nav-links').hide();
			}
        }).trigger('click');

    });

    Controller.prototype.togglePopUp = (function() {
        $popupTable = $('#box').closest('table');

        $('#box-enable').on('change', function () {
            $popupTable.find('tbody').show();
        });

        $('#box-disable').on('change', function () {
            $popupTable.find('tbody').hide();
        });

        $popupTable.find('thead input[type="radio"]:checked')
            .trigger('click')
            .trigger('change');
    });

    Controller.prototype.toggleLazyload = (function() {
        $lazyloadTable = $('#sgg-t-lazyload-enable').closest('table');

        $('#lazyLoadEnabled').on('change', function () {
            $lazyloadTable.find('tbody').show();
        });

        $('#lazyLoadDisabled').on('change', function () {
            $lazyloadTable.find('tbody').hide();
        });

        $lazyloadTable.find('thead input[type="radio"]:checked')
            .trigger('click')
            .trigger('change');
    });

    Controller.prototype.toggleIcons = (function() {
        var $table = $('#photo-icon').closest('table');

        $('#icons-enable').on('change', function () {
            $table.find('tbody').show();
        });

        $('#icons-disable').on('change', function () {
            $table.find('tbody').hide();
        });

        $table.find('thead input[type="radio"]:checked').trigger('click').trigger('change');
    });

    Controller.prototype.togglePosts = function () {
		var $postsEnable = $('.ggPostsEnableCl'),
            $toggleRow = $('select[name="quicksand[enabled]"]'),
            value = 0;

		$postsEnable.on('ifChanged', function () {
			var $currPostEnb = $(this);
			if($currPostEnb.is(':checked')) {
				value = parseInt($currPostEnb.val(), 10);
				if (value) {
					$toggleRow.attr('disabled', 'disabled');
					if ($toggleRow.val() > 0) {
						$.jGrowl('You cant use image shuffling option \n when post feed is enabled');
						$toggleRow.val('0');
					};
				} else {
					$toggleRow.removeAttr('disabled');
				}
			}
		}).trigger('ifChanged');
    };

    Controller.prototype.toggleAutoPosts = function() {
        var $autoposts = $("#autoposts"),
            $autopostsCategories = $("#autopostsCategories"),
            $autopostsElements = [
                $("#autopostsNumber").closest('tr'),
                $("#autopostsCategories").closest('tr')
            ],
            $postsElements = [
                $("#posts").closest('tr'),
                $("#pages").closest('tr'),
                $("#table-toolbar"),
                $("#gview_ui-jqgrid-htable"),

            ];

        $autopostsCategories.chosen({width: '200px'});
        // $autopostsCategories.next('div').find('li.search-field').height('35px');

        $autoposts.on('change', function () {
            var value = parseInt($(this).val(), 10);

            if (value) {
                for(var i in $autopostsElements){
                    $autopostsElements[i].show();
                }
                for(var i in $postsElements){
                    $postsElements[i].hide();
                }
            } else {
                for(var i in $autopostsElements){
                    $autopostsElements[i].hide();
                }
                for(var i in $postsElements){
                    $postsElements[i].show();
                }
            }
        }).trigger('change');
    }

    Controller.prototype.initSocialSharing = function(){
        var $table = $('#social-sharing').closest('table');

        $('#image-sharing-hidden,#popup-sharing-hidden').closest('tr').hide();

        $('#social-sharing-enable').on('change', function () {
            $table.find('tbody').show();
        });

        $('#social-sharing-disable').on('change', function () {
            $table.find('tbody').hide();
        });

        $table.find('thead input[type="radio"]:checked').trigger('click').trigger('change');

        //init gallery sharing checkbox
        var gallerySharingToggle = function(){
            var $input = $('#gallery-social-sharing').find('input'),
                $buttonsPositionTr = $('#gallery-sharing-buttons-position').closest('tr');
            if($input.is(':checked')){
                $buttonsPositionTr.show();
            }else{
                $buttonsPositionTr.hide();
            }
        };
        $('#gallery-social-sharing').find('input').on('click',function(){
            gallerySharingToggle();
        });
        gallerySharingToggle();

        var $settingSelectors = {
            'imageButtons' : {
                'enableInput' : $('#image-social-sharing').find('input'),
                'buttonsPositionSelect' : $('#image-sharing-buttons-position').find('select'),
                'buttonsAlignHorizontalTr' : $('#image-sharing-buttons-align-horizontal').closest('tr'),
                'buttonsAlignVerticalTr' : $('#image-sharing-buttons-align-vertical').closest('tr'),
            },
            'popupButtons' : {
                'enableInput' : $('#popup-social-sharing').find('input'),
                'buttonsPositionSelect' : $('#popup-sharing-buttons-position').find('select'),
                'buttonsAlignHorizontalTr' : $('#popup-sharing-buttons-align-horizontal').closest('tr'),
                'buttonsAlignVerticalTr' : $('#popup-sharing-buttons-align-vertical').closest('tr'),
            },
        };

        //init image sharing checkbox
        var buttonsPositionToggle = function(index){
            var set = $settingSelectors[index],
                buttonsPosition = set.buttonsPositionSelect.val(),
                $alignHorizontalTr = set.buttonsAlignHorizontalTr,
                $alignVerticalTr = set.buttonsAlignVerticalTr;

            if(buttonsPosition == 'top' || buttonsPosition == 'bottom'){
                $alignHorizontalTr.show();
                $alignVerticalTr.hide();
            }else{
                $alignHorizontalTr.hide();
                $alignVerticalTr.show();
            }
        };
        var socialSharingToggle = function(index){
            var set = $settingSelectors[index],
                $input = set.enableInput,
                $buttonsPositionTr = set.buttonsPositionSelect.closest('tr');

            if($input.is(':checked')){
                $buttonsPositionTr.show();
                buttonsPositionToggle(index);
            }else{
                $buttonsPositionTr.hide();
                set.buttonsAlignHorizontalTr.hide();
                set.buttonsAlignVerticalTr.hide();
            }
        };

        $('#image-social-sharing').find('input').on('click',function(){
            socialSharingToggle('imageButtons');
        });
        $('#image-sharing-buttons-position').find('select').on('change',function(){
            buttonsPositionToggle('imageButtons');
        });
        socialSharingToggle('imageButtons');

        $('#popup-social-sharing').find('input').on('click',function(){
            socialSharingToggle('popupButtons');
        });
        $('#popup-sharing-buttons-position').find('select').on('change',function(){
            buttonsPositionToggle('popupButtons');
        });
        socialSharingToggle('popupButtons');
    };

    Controller.prototype.toggleHorizontallScroll = function () {
        var $table = $('#horizontal-scroll').closest('table');

        $('#horizontal-scroll-enable').on('change', function () {
            $table.find('tbody').show();
        });

        $('#horizontal-scroll-disable').on('change', function () {
            $table.find('tbody').hide();
        });

        $table.find('thead input[type="radio"]:checked').trigger('click').trigger('change');
    };

    Controller.prototype.selectCover = function (e) {
        var target = $(e.currentTarget),
            covers = $('.covers'),
            cover  = $('#coverUrl');

        covers.find('li').removeClass('selected');
        target.parents('li').addClass('selected');

        cover.val(target.parents('li').data('url'));
    };

    Controller.prototype.savePosts = function () {
        jQuery('[name="posts[add]"]').on('click', $.proxy(function() {
            SupsysticGallery.Loader.show('Please, wait until post will be imported.');
            var request = SupsysticGallery.Ajax.Post({
                module: 'galleries',
                action: 'savePosts'
            });

            request.add('galleryId', parseInt(this.getParameterByName('gallery_id'), 10));
            request.add('id', parseInt(jQuery('[name="posts[current]"] option:selected').val()));

            request.send($.proxy(function (response) {
                jQuery("#ui-jqgrid-htable").jqGrid('addRowData', jQuery('[name="posts[current]"] option:selected').val() , {
                    id: jQuery('[name="posts[current]"] option:selected').val(),
                    image: response.photo,
                    title: jQuery('[name="posts[current]"] option:selected').text(),
                    author: response.post_author,
                    comments: response.comment_count,
                    type: response.type,
                    date: response.post_date
                });
                SupsysticGallery.Loader.hide();
                $.jGrowl('Done');
            }, this));
        }, this));

        jQuery('#remove-posts').on('click', $.proxy(function() {
            var request = SupsysticGallery.Ajax.Post({
                module: 'galleries',
                action: 'removePosts'
            });

            var postsId = new Array();
            jQuery('.ui-jqgrid [type="checkbox"]').each(function() {
                if($(this).attr('checked')) {
                    postsId.push($(this).closest('tr').find('[aria-describedby="ui-jqgrid-htable_id"]').text());
                    $(this).closest('tr').remove();
                }
            });

            request.add('galleryId', parseInt(this.getParameterByName('gallery_id'), 10));
            request.add('id', postsId);

            request.send($.proxy(function (response) {
                $.jGrowl('Removed');
            }, this));
        }, this));

        jQuery('#button-select-posts').on('click', function() {
            checkboxes = jQuery('.ui-jqgrid input[type="checkbox"]');
            checkboxes.prop("checked", !checkboxes.first().prop("checked")).iCheck('update');
        });
    }

    Controller.prototype.savePages = function () {
        jQuery('[name="pages[add]"]').on('click', $.proxy(function () {
            SupsysticGallery.Loader.show('Please, wait until page will be imported.');
            var request = SupsysticGallery.Ajax.Post({
                module: 'galleries',
                action: 'savePages'
            });

            request.add('galleryId', parseInt(this.getParameterByName('gallery_id'), 10));
            request.add('id', parseInt(jQuery('[name="pages[current]"] option:selected').val()));

            request.send($.proxy(function (response) {
                jQuery("#ui-jqgrid-htable").jqGrid('addRowData', jQuery('[name="pages[current]"] option:selected').val() , {
                    id: jQuery('[name="pages[current]"] option:selected').val(),
                    image: response.photo,
                    title: jQuery('[name="pages[current]"] option:selected').text(),
                    author: response.page_author,
                    comments: response.comment_count,
                    type: response.type,
                    date: response.page_date
                });
                SupsysticGallery.Loader.hide();
                $.jGrowl('Done');
            }, this));
        }, this));
    };

    Controller.prototype.initShadowDialog = function () {
        var $wrapper = $('#shadowDialog');

        $wrapper.dialog({
            autoOpen: false,
            modal:    true,
            width:    650,
            buttons:  {
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });

        Controller.prototype.initShadowSelect = function () {
            var $shadowColor = $('[name="thumbnail[shadow][color]"]'),
                $shadowOffsetX = $('[name="thumbnail[shadow][x]"]'),
                $shadowOffsetY = $('[name="thumbnail[shadow][y]"]'),
                $shadowBlur = $('[name="thumbnail[shadow][blur]"]');

            $wrapper.find('.shadow-preset').on('click', function() {
                var offsetX = parseInt($(this).data('offset-x')),
                    offsetY = parseInt($(this).data('offset-y')),
                    blur = parseInt($(this).data('blur')),
                    color = $(this).data('color');

                $shadowColor.attr('value', color);
                $shadowOffsetX.attr('value', offsetX);
                $shadowOffsetY.attr('value', offsetY);
                $shadowBlur.attr('value', blur);

                $shadowColor.trigger('change');

                $wrapper.dialog('close');
            });
        };

        Controller.prototype.openShadowDialog = function () {
            var $button = $('#chooseShadowPreset');

            $button.on('click', function() {
                $wrapper.dialog('open');
            });
        };
    };

    Controller.prototype.makeSettingsDefault = function(){
        var $button = $('#default-settings input');
        var galleryId = parseInt(this.getParameterByName('gallery_id'), 10);

        $button.on('click' , function () {
            var checked = $(this).prop('checked');
            if(checked){
                $.post(window.wp.ajax.settings.url, {
                    action: 'grid-gallery',
                    _wpnonce: SupsysticGallery.nonce,
                    route: {
                        module: 'galleries',
                        action: 'createdefaultgallerysettings'
                    },
                    id: galleryId
                }).success(function(response) {
                    if (response.success) {
                    }
                });
            }else{
                $.post(window.wp.ajax.settings.url, {
                    action: 'grid-gallery',
                    _wpnonce: SupsysticGallery.nonce,
                    route: {
                        module: 'galleries',
                        action: 'removedefaultgallerysettings'
                    },
                    id: galleryId
                }).success(function(response) {
                    if (response.success) {
                    }
                });
            }

        });

    };



    Controller.prototype.initImportSettingDialog = function () {

        var $wrapper = $('#settingsImportDialog'),
            galleryId = parseInt(this.getParameterByName('gallery_id'), 10);

        $wrapper.dialog({
            autoOpen: false,
            modal:    true,
            width:    350,
            buttons:  [
                {
                    text: 'Cancel',
                    click: function () {
                        $(this).dialog('close');
                    },
                },
                {
                    id: 'import-confirm-button',
                    text: 'Import',
                    click: function () {
                        $.post(window.wp.ajax.settings.url, {
                            action: 'grid-gallery',
                            _wpnonce: SupsysticGallery.nonce,
                            route: {
                                module: 'galleries',
                                action: 'importSettings'
                            },
                            from: $(this).find('.list').val(),
                            to: galleryId
                        }).success(function(response) {
                            if (response.success) {
                                window.location.reload();
                            }
                        });
                    },
                }
            ]
        });

        $('#openSettingsImportDialog').on('click', function(event) {
            event.preventDefault();
            $wrapper.dialog('open');

            var list = $wrapper.find('.list');
            if($wrapper.find('.import-gallery-loading').is(':visible')) {
                $.get(window.wp.ajax.settings.url, {
                    action: 'grid-gallery',
                    _wpnonce: SupsysticGallery.nonce,
                    route: {
                        module: 'galleries',
                        action: 'getGalleriesList'
                    }
                }).success(function (response) {
                    if (response.list) {
                        $.each(response.list, function (i, item) {
                            if (galleryId != item.id) {
                                list.append($('<option>', {
                                    value: item.id,
                                    text: item.title
                                }));
                            }
                        });
                        if (response.list.length < 2) {
                            $('#settingsImportDialog .import-not-available').show();
                        } else {
                            $('#settingsImportDialog .import').show();
                            $('#import-confirm-button').show();
                        }
                    }
                }).always(function() {
                    $wrapper.find('.import-gallery-loading').hide();
                });
            } 
            if($wrapper.find('.import').is(':hidden')) {
                $('#import-confirm-button').hide();
            }
        });
    };

    Controller.prototype.initCustomButtonsPrevieDialog = function () {
        $buttonsEditPresetDialog = $('.buttons-edit-preset-dialog-preview');

        $buttonsEditPresetDialog.dialog({
            autoOpen: false,
            modal:    true,
            width:    880,
            buttons:  {
                Cancel: function () {
                    $(this).dialog('close');
                },
                'Get Pro': function () {
                    url = $(this).find('a').attr('href');
                    window.open(url);
                    $(this).dialog('close');
                }
            }
        });

        $('#custom-buttons-preview input').on('click', function(event) {
            event.preventDefault();
            $buttonsEditPresetDialog.dialog('open');
        });
    };

    Controller.prototype.setPolaroidDefaultSettings = function () {
        $('input[name="thumbnail[overlay][background]"]').wpColorPicker('color', '#ededed');
        $('select[name="thumbnail[overlay][transparency]"]').val('1');
        $('input[name="captionBuilder[title][bgColor]"]').wpColorPicker('color', '#ededed');
        $('select[name="captionBuilder[title][bgColorTransparency]').val('1');
        $('input[name="captionBuilder[title][height]"]').val('33%');
        $('label[for="captBuilderTitlePositionCenterTop"]').trigger('click');
        $('input[name="captionBuilder[title][paddings][left]"]').val('10');
        $('input[name="captionBuilder[title][paddings][right]"]').val('10');
        $('input[name="captionBuilder[title][paddings][top]"]').val('0');
        $('input[name="captionBuilder[title][paddings][bottom]"]').val('15');
        $('input[name="captionBuilder[title][paddings][bottom]"]').val('15');
        var title = $('#captionBuilderTitleEnable'),
            description = $('#captionBuilderDescriptionEnable'),
            icons = $('#captionBuilderIconsEnable'),
            shadow = $('#showShadow');
        if(title.length && !title.is(':checked')) {
            title.trigger('click');
            title.prop('checked', true).iCheck('update');
        }
        if(description.length && description.is(':checked')) {
            description.trigger('click');
            description.prop('checked', false).iCheck('update');
        }
        if(icons.length && icons.is(':checked')) {
            icons.prop('checked', false).iCheck('update');
            icons.trigger('ifChanged');
        }
        if(shadow.length) {
            if(!shadow.is(':checked')) {
                shadow.prop('checked', true).iCheck('update');
                $('#hideShadow').prop('checked', false).iCheck('update');
                shadow.trigger('click');
            }
            $('input[name="thumbnail[shadow][color]"]').wpColorPicker('color', 'rgba(0, 0, 0, 1.0)');
            $('select[name="thumbnail[shadow][overlay]"]').val('0');
            $('input[name="thumbnail[shadow][blur]"]').val('15');
            $('input[name="thumbnail[shadow][x]"]').val('0');
            $('input[name="thumbnail[shadow][y]"]').val('4');

        }
    };

    Controller.prototype.polaroidEffectSettings = function () {
        var self = this;
        $('#polaroid-effect select').on('change', function(event) {
            event.preventDefault();
            var $overlayEffect = $('#overlayEffect').val()
            ,   $polaroidSettings = $('#polaroid-animation, #polaroid-scattering, #polaroid-frame-width').closest('tr');
            if ($(this).val() == 'true') {
                $polaroidSettings.removeClass('hidden');
                if ($overlayEffect !== 'polaroid') {
                    if(confirm('Caption Effect will change to Polaroid Style. Some settings, such as background Color, Transparency, caption paddings, as well as the shadows will be automatically changed.')) {
                        self.setPolaroidDefaultSettings();
                         $('#effectsPreview [data-grid-gallery-type="polaroid"]').trigger('click');
                    }
                }
            } else {
                $polaroidSettings.addClass('hidden');
                if ($overlayEffect == 'polaroid') {
                    $('#effectsPreview [data-grid-gallery-type]:first').trigger('click');
                }
            }
        }).trigger('change');

        $('#polaroid-animation select, #polaroid-scattering select, #polaroid-frame-width input').on('change', function(event) {
            event.preventDefault();
            clearTimeout($('#preview.gallery-preview').data('polaroidDebounce'));
            $('#preview.gallery-preview').data('polaroidDebounce',
                setTimeout(function() {
                    app.ImagePreview.initCaptionEffects();
                }, 300));
        });

        $('#preview.gallery-preview').on('updateCaptionBackground', function(event, background) {
            var $bgWrap = $('#preview .polaroid-bg-wrap');

            if (! $bgWrap.length) {
                var $figcaption = $('#preview .grid-gallery-caption[data-grid-gallery-type="polaroid"]');
                $figcaption.find('img').wrap('<div class="polaroid-bg-wrap">');
                $bgWrap = $figcaption.find('.polaroid-bg-wrap');
                $bgWrap.css({
                    'transition':  $('#preview .grid-gallery-caption').css('transition')
                });
            }

            $(this).find('.grid-gallery-caption').css('background-color', background);
        });
    };

    //Get Pro Loader
    Controller.prototype.initLoaderPrevieDialog = function () {
        $LoaderDialog = $('.loader-dialog-preview');

        $LoaderDialog.dialog({
            autoOpen: false,
            modal:    true,
            width:    450,
            buttons:  {
                Cancel: function () {
                    $(this).dialog('close');
                }
            },
            create: function (event) { 
                $(event.target).parent().css({
                    position: 'fixed'
                });
            }
        });

        $('#choosePreicon-free').on('click', function(event) {
            event.preventDefault();
            $LoaderDialog.dialog('open');
        });
        $('#preloadColor-free').on('change',function(){
            $LoaderDialog.dialog('open');
        });
    };
    Controller.prototype.togglePreload = (function() {
        $preloadTable = $('[name=preload]');

        $('#preload-enable').on('change', function () {
            $preloadTable.find('tbody').show();
        });

        $('#preload-disable').on('change', function () {
            $preloadTable.find('tbody').hide();
        });

        $preloadTable.find('thead input[type="radio"]:checked')
            .trigger('click')
            .trigger('change');
    });

    Controller.prototype.initOpenByLink = function(){
        var openByLink = $('#open-by-link').find('input'),
            galleryLinkTr = $('#gallery-link').closest('tr');

        var checkOpenLink = function(){
                if(openByLink.is(':checked')){
                    galleryLinkTr.show();
                }else{
                    galleryLinkTr.hide();
                }
            };
        openByLink.on('change',function(){
            setTimeout(function(){checkOpenLink()},100)
        });

        checkOpenLink();
    };

	Controller.prototype.slimScrollOnSizeEvent = (function(_self) {
		var offsetTop2 = Math.floor($("#gg-anl-main").offset().top)
		,	galleryType = $('[name="area[grid]"]').val()
		,	$mosaicParamsWrapper = $("#gg-mosaic-image-count-text-wrapper")
		,	$loadMoreLink = $('#gg-anl-load-more-link')
		,	isMosaicLayout2Used = ($('#sggMosaicLayout').find('option:selected').val() == 1)
		,	$mosaicLink = $('#gg-anl-mosaic-settings-link');
		
		_self.linksOyPositions = [];
		_self.linksOyPositions.push({
			'id': '#gg-anl-main',
			'offset': 0,
		});

		if(galleryType == 4 && $mosaicParamsWrapper.length && !isMosaicLayout2Used) {
			$mosaicLink.removeClass('ggSettingsDisplNone');
			_self.linksOyPositions.push({
				'id': '#gg-mosaic-image-count-text-wrapper',
				'offset': Math.abs(Math.floor($mosaicParamsWrapper.offset().top) - offsetTop2 - 40),
			});
		} else {
			$mosaicLink.addClass('ggSettingsDisplNone');
		}
		
		_self.linksOyPositions.push({
			'id': '#gg-anl-soc-share',
			'offset': Math.abs(Math.floor($("#gg-anl-soc-share").offset().top) - offsetTop2 - 40),
		});
		if(galleryType == 4 && !isMosaicLayout2Used) {
			$loadMoreLink.addClass('ggSettingsDisplNone');

		} else {
			$loadMoreLink.removeClass('ggSettingsDisplNone');
			_self.linksOyPositions.push({
				'id': '#gg-anl-load-more',
				'offset': Math.abs(Math.floor($("#gg-anl-load-more").offset().top) - offsetTop2 - 40),
			});
		}
		_self.linksOyPositions.push({
			'id': '#gg-anl-cust-button',
			'offset': Math.abs(Math.floor($("#gg-anl-cust-button").offset().top) - offsetTop2 - 40),
		});
		_self.linksOyPositions.push({
			'id': '#gg-anl-horiz-scroll',
			'offset': Math.abs(Math.floor($("#gg-anl-horiz-scroll").offset().top) - offsetTop2 - 40),
		});
		_self.linksOyPositions.push({
			'id': '#gg-anl-border-type',
			'offset': Math.abs(Math.floor($("#gg-anl-border-type").offset().top) - offsetTop2 - 40),
		});
		_self.linksOyPositions.push({
			'id': '#gg-anl-shadow',
			'offset': Math.abs(Math.floor($("#gg-anl-shadow").offset().top) - offsetTop2 - 40),
		});
		_self.linksOyPositions.push({
			'id': '#gg-anl-popup',
			'offset': Math.abs(Math.floor($("#gg-anl-popup").offset().top) - offsetTop2 - 40),
		});
		_self.linksOyPositions.push({
			'id': '#gg-anl-lazyload',
			'offset': Math.abs(Math.floor($("#gg-anl-lazyload").offset().top) - offsetTop2 - 40),
		});
		_self.linksOyPositions.push({
			'id': '#gg-anl-preloader',
			'offset': Math.abs(Math.floor($("#gg-anl-preloader").offset().top) - offsetTop2 - 40),
		});
        _self.linksOyPositions.push({
            'id': '#gg-anl-attributes',
            'offset': Math.abs(Math.floor($("#gg-anl-attributes").offset().top) - offsetTop2 - 40),
        });
		_self.linksOyPositions.push({
			'id': '#gg-anl-caption-add-sett',
			'offset': Math.abs(Math.floor($("#gg-anl-caption-add-sett").offset().top) - offsetTop2 - 40),
		});

		$('.settings-wrap').slimScroll({}).off('slimscrolling')
			.on('slimscrolling', null, { 'oy': _self.linksOyPositions }, Controller.prototype.slimScrollOnScrollEvent);
	});

	Controller.prototype.initSubMenuFastLinks = (function() {
		var self = this;
		resizeEvent('.form-gall-settings div[data-tab="area"]', function() {
			self.slimScrollOnSizeEvent(self);
		});

		$('.gg-anchor-nav-links').on('click', function(e1, funcParams) {
			e1.preventDefault();
			var $settingsWrap = $('.settings-wrap')
			,	urlLink = $(this).attr('href')
			,	$linkItem = $(urlLink)
			,	$topItem = $("#gg-anl-main");
			if($linkItem.length) {
				var offsetLink = $linkItem.offset().top
				,	offsetTop = $topItem.offset().top
				,	offsetAbs = Math.abs(offsetLink -offsetTop);
				// if need to set start position
				if(funcParams && funcParams.offsetScTop) {
					offsetAbs = funcParams.offsetScTop;
				}
				if(!isNaN(offsetAbs)) {
					$settingsWrap.slimScroll({ scrollTo: offsetAbs + 'px' });
				}
			}
		});

		// init anchor link
		setTimeout(function() {
			var slScrollTopPos = parseInt($('#slimScrollStartPos').val());
			$('.gg-anchor-nav-links[href="#gg-anl-main"]').trigger('click', {'offsetScTop':slScrollTopPos});
		}, 500);
	});

	Controller.prototype.slimScrollOnScrollEvent = (function(e, pos) {

		if(e && e.data && e.data.oy) {
			var ind1 = 0
			,	$activeItem = $('.gg-anchor-nav-links.active')
			,	isFind = false;
			while(ind1 < (e.data.oy.length - 1) && !isFind) {
				if(e.data.oy[ind1].offset <= pos && e.data.oy[ind1+1].offset > pos) {
					isFind = ind1;
					ind1 = e.data.oy.length;
				}
				ind1++;
			}
			// if current position at last anchor
			if(isFind == false && ind1 == 8) {
				isFind = ind1;
			}
			//check curr active item
			var activeId = $activeItem.attr('href');
			if(e.data.oy[isFind] && activeId != e.data.oy[isFind].id) {
				if($activeItem.length) {
					// remove active class
					$activeItem.removeClass('active');
				}
				// add active class
				$('.gg-anchor-nav-links[href="' + e.data.oy[isFind].id + '"]').addClass('active');
			}
		}
	});

	Controller.prototype.initOtherPluginsConf = (function() {
		$('#enableForMembershipFake').on('change', function() {
			if($(this).val() == 1) {
				$('.gg-membership-plug-info').show();
			} else {
				$('.gg-membership-plug-info').hide();
			}
		});
		$('#enableForMembership').on('change', function() {
			$('#hiddenInpMembershipEnableVal').val($(this).val());
		});
	});

	Controller.prototype.initCloneButton = (function() {
		var $cloneCreateButton = $('#ggCreateClone')
		,	galleryId = parseInt(this.getParameterByName('gallery_id'), 10)
		,	$modalTypeCloneSelector = $('#ggCloneTypeSelector')
		,	$cloneModalWindow = $('#ggCloneModalWndId');

		$cloneModalWindow.dialog({
			autoOpen: false,
			modal: true,
			width: 350,
			buttons: [{
				text: 'Cancel',
				click: function () {
					$(this).dialog('close');
				},
			},
				{
					id: 'clone-type-button-ok',
					text: 'Ok',
					click: function () {
						if($cloneCreateButton.attr('disabled') != 'disabled') {
							$cloneCreateButton.attr('disabled', 'disabled');
							app.Loader.show($('#ggMsgCloningGallery').val());
							var cloneRequest = app.Ajax.Post({
								'module': 'galleries',
								'action': 'clone',
								'gallery_id': galleryId,
								'clone_type': $modalTypeCloneSelector.val(),
							});

							cloneRequest.send(function (response) {
								var message = $('#ggMsgServerInternalError').val();
								if(response && (response.isError == true || !response.newGalleryId)) {
									if(response.message) {
										message = response.message
									}
									$.jGrowl(message);
								} else {
									window.location = $cloneCreateButton.attr('data-url') + '&oldGalleryId=' + galleryId + '&gallery_id=' + response.newGalleryId+'&clone_type=' + $modalTypeCloneSelector.val();
								}

								$cloneCreateButton.removeAttr('disabled');
								app.Loader.hide();
							}).fail(function(responce) {
								$cloneCreateButton.removeAttr('disabled');
								$.jGrowl($('#ggMsgServerInternalError').val());
								app.Loader.hide();
							});
						}
					},
				}
			]
		});
		var $cloneModalBtnOk = $('#clone-type-button-ok');

		$modalTypeCloneSelector.on('change', function() {
			if($(this).val() == 0) {
				$cloneModalBtnOk.prop('disabled', true);
			} else {
				$cloneModalBtnOk.prop('disabled', false);
			}
		}).trigger('change');

		$cloneCreateButton.on('click', function(event) {
			event.preventDefault();
			$cloneModalWindow.dialog('open');
		});
	});

	Controller.prototype.checkCloneParam = (function() {
		var clone_type = parseInt(this.getParameterByName('clone_type'), 10)
		,	galleryId = parseInt(this.getParameterByName('gallery_id'), 10)
		,	selfContr = this
		,	redirectUrl = $('#ggCreateClone').attr('data-url') + '&gallery_id=' + galleryId;

		if(!isNaN(clone_type)) {
			// prepare other parts
			if(app) {
				app.Loader.show($('#ggMsgCloningGallery').val());
				setTimeout(function() {
					if(clone_type != 2) {
						if(app && app.proSettings && app.proSettings.prepareGalleryForClone) {
							// watermark check
							$(document).on('ggProSettingsWaterMarkResultEvent', function(event, result, message) {
								if(result == 1 && message) {
									$.jGrowl(message);
								}
								selfContr.checkForOptimization();
							});
							app.proSettings.prepareGalleryForClone();
						} else {
							selfContr.checkForOptimization();
						}
					} else {
						window.location = redirectUrl;
						app.Loader.hide();
					}
				}, 1000);
			}
		}
	});

    Controller.prototype.checkForOptimization = (function() {
		var ioServiceParams = null
		,	self = this
		,	galleryInfo = null
		,	urlLogList = []
		,	galleryId = parseInt(this.getParameterByName('gallery_id'), 10)
		,	galleries = {};
		galleries[galleryId] = null;

		try {
			ioServiceParams = JSON.parse($('#ggIoParams').val())
		} catch(exc1) {
			ioServiceParams = null;
		}
		$(document).on('ggCloneImageOptimizeEndEvent', function(event, res2) { 
			//save to db 
			if(res2 == 1 && galleryInfo && urlLogList.length) {
				galleryInfo.optimizePreview = 1;

				for(ind in urlLogList) {
					var oneImg = urlLogList[ind]
					,	optimizeSize = 0
					,	previousSize = 0;
					// if not error for this image
					if(oneImg.imgInfo) {
						if(oneImg.imgInfo.optSize && oneImg.imgInfo.restoreSize) {
							optimizeSize += parseFloat(oneImg.imgInfo.optSize);
							previousSize += parseFloat(oneImg.imgInfo.restoreSize);
						}

						if(galleryInfo[oneImg.gId]) {
							galleryInfo[oneImg.gId].imgCount = oneImg.iCount;
						}
					}
				}

				// save data to optimize table
				var request = SupsysticGallery.Ajax.Post({
					module: 'optimization',
					action: 'saveOptimizeInfoToDb',
					data: galleryInfo,
				});
				// nothing to show
				request.send(function (response) {
					self.checkForCdn();
				}).fail(function() {
					self.checkForCdn();
				});

			} else {
				self.checkForCdn();
			}
		});

		if(ioServiceParams != null
			&& ioServiceParams.setting
			&& ioServiceParams.current
			&& ioServiceParams.setting[ioServiceParams.current]
			&& ioServiceParams.setting[ioServiceParams.current].auth_key) {
			// loading gallery image list
			var request = app.Ajax.Post({
				module: 'optimization',
				action: 'getPhotoList',
				data: {
					'optimize-preview': 1,
					'galleries': galleries,
				},
			});

			app.Loader.show($('#ggMsgGalleryImageOptimizing').val());
			request.send(function (response) {
				if (response && response.success == true && response.photos && response.galleryInfo) {

					var keys = Object.keys(response.galleryInfo)
					,	photos = response.photos;
					if(photos && keys.length) {
						var currPhoto = 0
						,	countPhoto = 0
						,	ajaxPromise = new $.Deferred().resolve()
						,	oneRequest

						,	currLogInd = 0
						,	serviceError = false
						,	currAjaxSend = false
						,	msgOpt = $('#ggMsgOptimized').val()
						,	msgOf = $('#ggMsgOf').val()
						,	msgImages = $('#ggMsgImages').val()
						,	msgServerInternalError = $('#ggMsgServerInternalError').val();

						galleryInfo = response.galleryInfo;
						galleryInfo.serviceCode =ioServiceParams.current;
						galleryInfo.isRestore = 1;

						if(photos[keys[0]]) {
							countPhoto = photos[keys[0]].length;
						}

						// prepare Log List
						for(var key in keys) {
							currPhoto = 0;
							if(photos[keys[key]] && photos[keys[key]].length > 0) {
								countPhoto = photos[keys[key]].length;
								while(currPhoto < countPhoto) {
									urlLogList[currLogInd] = {
										'gInd': parseInt(key),
										'gId': keys[key],
										'gCount': keys.length,
										'iInd': currPhoto,
										'iCount': countPhoto,
										'url': photos[keys[key]][currPhoto],
									};
									currLogInd++;
									currPhoto++;
								}
							}
						};

						function processOneOptimizeImage(currIndex, logObject) {
							oneRequest = app.Ajax.Post({
								module: 'optimization',
								action: 'optimizeOneImage',
								data: {
									'currentServiceCode': galleryInfo.serviceCode,
									'auth_data': ioServiceParams.setting[ioServiceParams.current],
									'restoreSrc': galleryInfo.isRestore,
									'url': logObject.url,
								},
							});

							currAjaxSend = oneRequest.send(function(opResponse) {
								$.jGrowl(msgOpt + ' ' + (logObject.iInd+1) + ' ' + msgOf + ' ' + logObject.iCount + ' ' + msgImages);
								if(opResponse) {
									if(!opResponse.success) {
										$.jGrowl(opResponse.message ? opResponse.message: msgServerInternalError);
									}
									if(opResponse.imgInfo) {
										logObject.imgInfo = opResponse.imgInfo;
									}
									if(opResponse.serviceError) {
										serviceError = true;
										$(document).trigger('ggCloneImageOptimizeEndEvent');
									}
								}
								if(currIndex == currLogInd-1) {
									$(document).trigger('ggCloneImageOptimizeEndEvent', [1]);
								}
							}).fail(function (opResponse, statusText) {
								$.jGrowl(msgOpt + ' ' + (logObject.iInd+1) + ' ' + msgOf + ' ' + logObject.iCount + ' ' + msgImages);
								if(currIndex == currLogInd-1 && statusText != "abort") {
									$(document).trigger('ggCloneImageOptimizeEndEvent', [1]);
								}
							});
							return currAjaxSend;
						}

						$.each(urlLogList, function(index, oneElem) {
							ajaxPromise = ajaxPromise.then(function() {
								if(!serviceError) {
									return processOneOptimizeImage(index, oneElem);
								}
							}, function(responce, statusText) {
								if(statusText == "abort") {
									serviceError = true;
								}
								if(!serviceError) {
									return processOneOptimizeImage(index, oneElem);
								} else {
									$.jGrowl(msgServerInternalError);
									$(document).trigger('ggCloneImageOptimizeEndEvent');
								}
							});
						});
					}

				} else {
					$.jGrowl($('#ggMsgImgOptimizationErrorOcured').val());
					$(document).trigger('ggCloneImageOptimizeEndEvent');
				}
			}).fail(function () {
				$.jGrowl($('#ggMsgImgOptimizationErrorOcured').val());
				$(document).trigger('ggCloneImageOptimizeEndEvent');
			});
		} else {
			$(document).trigger('ggCloneImageOptimizeEndEvent');
		}
    });

	Controller.prototype.checkForCdn = (function() {
		var galleryId = parseInt(this.getParameterByName('gallery_id'), 10)
		,	cdnParams = null
		,	self = this
		,	galleryInfo
		,	galleries = {};
		galleries[galleryId] = null;

		try {
			cdnParams = JSON.parse($('#ggCdnParams').val());
		} catch(e) {
			cdnParams = null;
		}
		
		$(document).on('ggCloneCdnEndEvent', function(event, res1) {
			if(galleryInfo && res1 == 1) {
				var request = SupsysticGallery.Ajax.Post({
					module: 'optimization',
					action: 'saveCdnInfoToDb',
					data: {
						'gallery-obj': galleryInfo,
						'serviceCode': cdnParams.current,
					},
				});
				// nothing to show
				var ajax1 = request.send(function (response) {
					app.Loader.hide();
					window.location = $('#ggCreateClone').attr('data-url') + '&gallery_id=' + galleryId;;
				}).fail(function(response2) {
					app.Loader.hide();
					window.location = $('#ggCreateClone').attr('data-url') + '&gallery_id=' + galleryId;;
				});
			} else {
				app.Loader.hide();
				window.location = $('#ggCreateClone').attr('data-url') + '&gallery_id=' + galleryId;
			}
		});
		
		if(cdnParams 
			&& cdnParams.current
			&& cdnParams.setting
			&& cdnParams.setting[cdnParams.current]
			&& cdnParams.setting[cdnParams.current].zone_name
			&& cdnParams.setting[cdnParams.current].u_name
			&& cdnParams.setting[cdnParams.current].base_ftp_path
			&& cdnParams.setting[cdnParams.current].u_pass) {

			var request = app.Ajax.Post({
				module: 'optimization',
				action: 'getCdnPhotoList',
				data: {
					'optimize-preview': 1,
					'galleries': galleries,
					'isFilePath': 1,
				},
			});

			app.Loader.show($('#ggMsgGalleryTransferToCnd').val());
			request.send(function (response) {
				if (response && response.success == true && response.photos && response.galleryInfo) {

					var keys = Object.keys(galleries)
					,	photoList = response.photos
					,	currPhoto = 0
					,	serviceError = false
					,	hasError = false
					,	ajaxPromise = new $.Deferred().resolve()
					,	oneRequest
					,	photoLogList = []
					,	currLogInd = 0
					,	countPhoto = 0
					,	triggerRun = false
					,	msgTransfer = $('#ggMsgTransfer').val()
					,	msgOf = $('#ggMsgOf').val()
					,	msgImages = $('#ggMsgImages').val()
					,	msgServerInternalError = $('#ggMsgServerInternalError').val();

					galleryInfo = response.galleryInfo;

					// prepare Log List
					for(var key in keys) {
						currPhoto = 0;
						if(photoList[keys[key]] && photoList[keys[key]].length > 0) {
							countPhoto = photoList[keys[key]].length;
							while(currPhoto < countPhoto) {
								photoLogList[currLogInd] = {
									'iInd': currPhoto,
									'iCount': countPhoto,
									'photoObj': photoList[keys[key]][currPhoto],
								};
								currLogInd++;
								currPhoto++;
							}
						}
					};

					function processOneTransferImage(currIndex, logCdnObject) {
						oneRequest = app.Ajax.Post({
							module: 'optimization',
							action: 'transferOneImage',
							data: {
								'auth_data': cdnParams,
								'isDelete': 0,
								'photoObj': logCdnObject.photoObj,
							},
						});

						this.ajaxSendObj = oneRequest.send(function(opResponse) {
							$.jGrowl(msgTransfer + ' ' + (logCdnObject.iInd+1) + ' ' + msgOf + ' ' + logCdnObject.iCount + ' ' + msgImages);
							if(opResponse) {
								if(!opResponse.success) {
									$.jGrowl(opResponse.message ? opResponse.message: msgServerInternalError);
									hasError = true;
								}
							}
							if(currIndex == currLogInd-1) {
								$(document).trigger('ggCloneCdnEndEvent', [1]);
							}
						}).fail(function (opResponse, statusText) {
							if(statusText == 'error') {
								$.jGrowl(opResponse.statusText);
								hasError = true;
							}
							$.jGrowl(msgTransfer + ' ' + (logCdnObject.iInd+1) + ' ' + msgOf + ' ' + logCdnObject.iCount + ' ' + msgImages);
							if(currIndex == currLogInd-1 && statusText != "abort") {
								$(document).trigger('ggCloneCdnEndEvent', [1]);
							}
						});
						return this.ajaxSendObj;
					}

					$.each(photoLogList, function(index, oneElem) {
						ajaxPromise = ajaxPromise.then(function() {
							if(!serviceError) {
								return processOneTransferImage(index, oneElem);
							}
						}, function(responce, statusText) {
							if(statusText == "abort") {
								serviceError = true;
							} else if(statusText == 'error') {
								$.jGrowl(responce.statusText);
								hasError = true;
							}
							if(!serviceError) {
								return processOneTransferImage(index, oneElem);
							}
						});
					});

				} else {
					$.jGrowl(msgServerInternalError);
					$(document).trigger('ggCloneCdnEndEvent');
				}
			}).fail(function () {
				$.jGrowl(msgServerInternalError);
				$(document).trigger('ggCloneCdnEndEvent');
			});
		} else {
			$(document).trigger('ggCloneCdnEndEvent');
		}
	});

	Controller.prototype.callExtenedFunc = (function(funcName, funcParams) {
		// is settings exists
		if(this.checkCurrentSettPage) {
			if(this.constructor.prototype[funcName]) {
				if(!funcParams) {
					funcParams = [];
				}
				return this.constructor.prototype[funcName].call(this, funcParams);
			} else {
				console.log("Error! Can't find function: " + funcName);
			}
		}
		return null;
	});

    $(document).ready(function () {
        var qs = new URI().query(true), controller;

        if (qs.module === 'galleries' && qs.action === 'settings') {
            controller = new Controller();

            $('a').not('.hi-icon.fa, .iris-palette, .nav-tab, .wp-color-result, .gg-anchor-nav-links, .caption-available-in-pro-link, .sggLinkToProVer').on('click', function(event) {
                if (controller.settingsChanged && !confirm($('.settings-wrap').data('leave-confirm'))) {
                    event.stopPropagation();
                    event.preventDefault();
                    return false;
                }
            });

            controller.setScroll();
            controller.initSaveDialog();
            controller.initDeleteDialog();
            controller.initLoadDialog();
            controller.initThemeDialog();
            controller.initEffectsDialog();
            controller.initIconsDialog();
            controller.initLoaderPrevieDialog();
            controller.togglePreload();

            controller.initEffectPreview();

            controller.initShadowDialog();
            controller.initImportSettingDialog();
			controller.initCloneButton();
            controller.initShadowSelect();
            controller.openShadowDialog();

            controller.toggleArea();
            controller.toggleShadow();
            controller.toggleBorder();
            controller.toggleCaptions();
            controller.togglePopUp();
            controller.toggleLazyload();
            controller.toggleIcons();
            controller.toggleHorizontallScroll();

            controller.initSocialSharing();
            controller.initThemeSelect();

            controller.savePosts();
            controller.savePages();

            controller.showReviewNotice();

            controller.saveButton();
            controller.togglePosts();
            controller.togglePostsTable();
            controller.toggleAutoPosts();
            controller.areaNotifications();
            controller.setInputColor();
            controller.toggleSlideShow();

            controller.initOpenByLink();

            controller.makeSettingsDefault();

            controller.polaroidEffectSettings();
			controller.initOtherPluginsConf();

            controller.initCustomButtonsPrevieDialog();
			controller.checkCloneParam();

            // Save as preset dialog
            $('#btnSaveAsPreset').on('click', controller.openSaveDialog);

            // Delete preset dialog
            $('#btnDeletePreset').on('click', controller.openDeleteDialog);

            // Load from preset dialog
            $('#btnLoadFromPreset').on('click', controller.openPresetDialog);

            // Delete gallery
            $('.delete').on('click', controller.remove);

            // Change the tab
            $('.change-tab')
                .on('click', $.proxy(controller.changeTab, controller));

            // Open theme dialog
            $('#chooseTheme').on('click', controller.openThemeDialog);

            // Open effects dialog
            $('#chooseEffect').on('click', controller.openEffectsDialog);

            // Cover
            $('.covers img').on('click', controller.selectCover);

			controller.initSubMenuFastLinks();
			$(document).trigger('sggInitGallerySettingsPro', controller);
			//controller.callExtenedFunc('initExtendedGallerySettings', ['params1', 'params2']);
			// prevent click for icons
			$(document).on('click', '#preview .hi-icon.fa', function(event) {
				event.preventDefault();
			});
            $(document).one('input ifClicked', '.supsystic-plugin :input',function(event) {
                controller.settingsChanged = true;
            });
            app.SettingsController = controller;

		} else if(qs.module === 'galleries' && qs.action === 'view') {
			var viewController = new ggSettingsView();
			var galleryTabs = new ggGalleryTabs();
		}
    });

	function ggSettingsView() {
		this.init();
	}

	ggSettingsView.prototype.init = (function() {
		this.initPerPageSelector();
	});

	ggSettingsView.prototype.initPerPageSelector = (function() {
		var self1 = this;
		$('#gg-pagination-per-page').on('change', function(){
			var param = $(this).val()
			,	paramsArr = self1.getArrayFromQuery();
			paramsArr['gpp'] = param;
			delete paramsArr['gp'];
			var urlQuery = $.param(paramsArr);
			if(urlQuery && urlQuery.length) {
				window.location.search = '?' + urlQuery;
			}
		});
	});

	ggSettingsView.prototype.getArrayFromQuery = (function() {
		var res = {};
		if(window.location.search && window.location.search.length) {
			var urlQquery = window.location.search.substring(1);
			if(urlQquery && urlQquery.length) {
				var urlParams = urlQquery.split('&');
				if(urlParams && urlParams.length) {
					for(var i = 0; i < urlParams.length; i++) {
						var pair = urlParams[i].split('=');
						res[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
					}
				}
			}
		}
		return res;
	});

    function ggGalleryTabs() {
		var mtiSelf = this;
		$('.gg-tab-links .gg-tab-link').on('click', function() {
			var $self = $(this)
			,	$parent = $self.parent();

			$parent.find('.gg-tab-link').each(function() {
				$(this).removeClass('active');
			});
			$self.addClass('active');

			if($parent.data('tabs') && $self.data('tab-info')) {
				mtiSelf.tabsVisibilityUpdate($parent.data('tabs'), $self.data('tab-info'));
			}
		});
	};

	ggGalleryTabs.prototype.tabsVisibilityUpdate = (function(parentDataInfo, thisDataInfo) {
		$('.gg-tab-pages[data-tabs="' + parentDataInfo + '"] .gg-tab-page').addClass('ggSettingsDisplNone')
		$('.gg-tab-pages[data-tabs="' + parentDataInfo + '"] .gg-tab-page[data-tab-info="' + thisDataInfo + '"]').removeClass('ggSettingsDisplNone');
	});

	/**
	 * function run functionHandler when size of divSelector changed
	 * work only for Height
	 * @param divSelector
	 * @param functionHandler
	 */
	function resizeEvent(divSelector, functionHandler) {
		if(functionHandler && divSelector) {
			var _resizeInterval = setInterval(_resizeIntervalTick, 200)
			,	_lastHeight = 0;

			function _resizeIntervalTick() {
				var elementHeight = $(divSelector).height();
				if(elementHeight != _lastHeight) {
					_lastHeight = elementHeight;
					functionHandler();
				}
			};
		}
	}

}(window.SupsysticGallery = window.SupsysticGallery || {}, jQuery));

// Preview

(function ($, Gallery) {
    var getSelector = (function (fieldName) {
		return '.caption-type[data-gg-cb-type="captions-icons"] [name="' + fieldName + '"]';
    });


    function ImagePreview(enabled) {
        this.$window = $('#preview.gallery-preview');
        this.loadedFonts = [];

        if (enabled) {
            this.init();
        }

        this.$window.on('preview.refresh', $.proxy(function(event) {
            this.init();
        }, this));
    }

    ImagePreview.prototype.importFontFamily = (function(familyName) {
        var styleId = 'sggFontFamilyStyle',
            $style = $('#' + styleId);
        if (!$style.length) {
            $style = $('<style/>', { id: styleId });
            $('head').append($style);
        }
        familyName = familyName.replace(/\s+/g, '+').replace(/"/g, '');

        var obj = document.getElementById(styleId),
            sheet = obj.sheet || obj.styleSheet;
        if(this.loadedFonts.indexOf(familyName) === -1) {
            if(sheet.insertRule) {
                sheet.insertRule('@import url("//fonts.googleapis.com/css?family=' + familyName + '"); ', 0);
            } else if(sheet.addImport) {
                sheet.addImport('//fonts.googleapis.com/css?family=' + familyName);
            }
            this.loadedFonts.push(familyName);
        }
    });

    ImagePreview.prototype.setProp = (function (selector, props) {
        this.$window.find(selector).css(props);
    });

    ImagePreview.prototype.setDataset = (function (selector, name, value) {
        this.$window.find(selector).attr(name, value);
    });

    ImagePreview.prototype.initBorder = (function () {
        var fieldNames = {
            type: 'thumbnail[border][type]',
            color: 'thumbnail[border][color]',
            width: 'thumbnail[border][width]',
            radius: 'thumbnail[border][radius]',
            radiusUnit: 'thumbnail[border][radius_unit]'
        };

        $(getSelector(fieldNames.type)).on('change', $.proxy(function (e) {
            this.setProp('figure', { borderStyle: $(e.currentTarget).val() });
        }, this)).trigger('change');

        $('#border-color a.wp-color-result').attrchange({
            trackValues: true,
            callback: function (e) {
                if(e.attributeName == 'style') {
                    $('#preview .grid-gallery-caption').css('border-color', e.newStyle);
                }
            }
        });

        $(getSelector(fieldNames.color)).on('change', $.proxy(function (e) {
            this.setProp('figure', { borderColor: $(e.currentTarget).val() });
        }, this)).trigger('change');

        $(getSelector(fieldNames.width)).bind('change paste keyup', $.proxy(function (e) {
            this.setProp('figure', { borderWidth: $(e.currentTarget).val() });
        }, this)).trigger('change');

        $(getSelector(fieldNames.radius) + ',' + getSelector(fieldNames.radiusUnit))
            .bind('change paste keyup', $.proxy(function () {
                var $value = $(getSelector(fieldNames.radius)),
                    $unit  = $(getSelector(fieldNames.radiusUnit)),
                    unitValue = 'px';

                if (parseInt($unit.val(), 10) == 1) {
                    unitValue = '%';
                }

                this.setProp('figure', { borderRadius: $value.val() + unitValue });

            }, this))
            .trigger('change');
    });

	ImagePreview.prototype.updateIcons = (function() {
		var captBuilderVal = $('.ggUserCaptionBuilderCl:checked').val()
		,	captionBuilderIconsEnable = $('#captionBuilderIconsEnable:checked').length
		,	captionIconsEnable = $('#icons-enable:checked').length
		,	showFewIconsSel = $('#showFewIconsSel').val()
		,	toShowVideoIcon = 0
		,	toShowLinkIcon = 0
		,	toShowPopupIcon = 0
        ,   toShowDownloadIcon = 0
		,	toShowIcons = 0
		,	$previewVideoIcon = $('#preview .hi-icon.gg-icon-video')
		,	$previewLinkIcon = $('#preview .hi-icon.gg-icon-link')
		,	$previewPopupIcon = $('#preview .hi-icon.gg-icon-popup')
        ,   $previewDownloadIcon = $('#preview .hi-icon.gg-icon-download')
		;
		if(captBuilderVal == 1 && captionBuilderIconsEnable) {
			toShowIcons = 1
		} else if(captBuilderVal == 0 && captionIconsEnable) {
			toShowIcons = 1
		}
		// is icons visible
		if(toShowIcons == 1) {
			if(showFewIconsSel == 'params') {
				toShowVideoIcon = $('#showVideoIconInp:checked').length;
				toShowLinkIcon = $('#showLinkIconInp:checked').length;
				toShowPopupIcon = $('#showPopupIconInp:checked').length;
                toShowDownloadIcon = $('#showDownloadIconInp:checked').length;
			} else {
				toShowVideoIcon = 1;
				toShowLinkIcon = 1;
				toShowPopupIcon = 1;
			}
		}
		// icon type to show
		if(toShowVideoIcon == 1) {
			$previewVideoIcon.removeClass('ggSettingsDisplNone');
		} else {
			$previewVideoIcon.addClass('ggSettingsDisplNone');
		}
		if(toShowLinkIcon == 1) {
			$previewLinkIcon.removeClass('ggSettingsDisplNone');
		} else {
			$previewLinkIcon.addClass('ggSettingsDisplNone');
		}
		if(toShowPopupIcon == 1) {
			$previewPopupIcon.removeClass('ggSettingsDisplNone');
		} else {
			$previewPopupIcon.addClass('ggSettingsDisplNone');
		}
        if(toShowDownloadIcon == 1) {
            $previewDownloadIcon.removeClass('ggSettingsDisplNone');
        } else {
            $previewDownloadIcon.addClass('ggSettingsDisplNone');
        }
	});

	ImagePreview.prototype.initSharedPropsForIcons = (function() {
		var selfIp = this;

		$('#showVideoIconInp').on('ifChanged', function() {
			selfIp.updateIcons();
		});
		$('#showLinkIconInp').on('ifChanged', function() {
			selfIp.updateIcons();
		});
		$('#showPopupIconInp').on('ifChanged', function() {
			selfIp.updateIcons();
		});
        $('#showDownloadIconInp').on('ifChanged', function() {
            selfIp.updateIcons();
        });
		// Init Show Few Icons parameter
		$('#showFewIconsSel').on('change', function() {
			var $this = $(this)
			,	$sggFewIconsShowingRow = $('#sggFewIconsShowingRow')
			,	selVal = $this.val()
			;
			if(selVal == 'default') {
				$sggFewIconsShowingRow.addClass('ggSettingsDisplNone');
			} else {
				$sggFewIconsShowingRow.removeClass('ggSettingsDisplNone');
			}
			selfIp.updateIcons();
		});
		$('#showFewIconsSel').trigger('change');
	});

    ImagePreview.prototype.initShadow = (function () {
        var _this = this;

        var fieldNames = {
                color: '#form-settings [name="thumbnail[shadow][color]"]',
                blur: '#form-settings [name="thumbnail[shadow][blur]"]',
                x: '#form-settings [name="thumbnail[shadow][x]"]',
                y: '#form-settings [name="thumbnail[shadow][y]"]'
            },
            selectors = $.map(fieldNames, function(item) {
                return item;
            });

        updateShadowProp = function(properties) {
            _this.setProp('figure', properties);
        }

        $(selectors.join(',')).off('change paste keyup').on('change paste keyup', function() {
            boxShadow = $(fieldNames.x).val() + 'px ' + $(fieldNames.y).val() + 'px ' + $(fieldNames.blur).val() + 'px ' + $(fieldNames.color).val();
            _this.$window.find('figure')
            .attr('data-box-shadow', boxShadow)
            .trigger('shadowChange');
        });

        $('[name="use_shadow"]').off('change').on('change', function() {
            if ($(this).val() == 1) {
                $(fieldNames.x).trigger('change');
            } else {
                updateShadowProp({
                    boxShadow: 'none'
                });
            }
        });

        $('[name="use_shadow"]:checked').trigger('change');
    });

    ImagePreview.prototype.initMouseShadow = (function() {
        var self = this,
        wrapper = {
            element: '#preview figure.grid-gallery-caption',
            $node: $('#preview figure.grid-gallery-caption'),
            toggleEvents: function() {
                this.$node.off('hover', showOver);
                this.$node.off('hover', hideOver);
            }
        },
        shadow = wrapper.$node.data('box-shadow'),
        showOver = function(event) {
            if (event.type === 'mouseenter') {
                $(this).css('box-shadow', shadow);
            } else {
                $(this).css('box-shadow', 'none');
            }
        },
        hideOver = function(event) {
            if (event.type === 'mouseenter') {
                $(this).css('box-shadow', 'none');
            } else {
                $(this).css('box-shadow', shadow);
            }
        };

        wrapper.$node.on('shadowChange', function() {
            shadow = $(this).attr('data-box-shadow');
            $('#useMouseOverShadow').trigger('change');
        });

        $('#useMouseOverShadow').on('change',function() {
            value = parseInt($('#useMouseOverShadow option:selected').val(), 10);
            wrapper.toggleEvents();

            if (value == 1) {
                wrapper.$node.css('box-shadow', 'none');
                wrapper.$node.on('hover', showOver);
            }

            if (value == 2) {
                wrapper.$node.css('box-shadow', shadow);
                wrapper.$node.on('hover', hideOver);
            }

            if(!value) {
                wrapper.$node.css('box-shadow', shadow);
            }

        }).trigger('change');
    });

    ImagePreview.prototype.initOverlayShadow = (function() {
        var wrapper = {
            element: '.grid-gallery-caption img',
            $node: $('#preview figure.grid-gallery-caption')
        },
        $toggle = $('[name="thumbnail[shadow][overlay]"]'),
        self = this,
        overlayShadow = function(event) {
            if (event.type === 'mouseenter') {
                self.setProp(wrapper.element, {opacity: '1.0'});
            } else {
                 self.setProp(wrapper.element, {opacity: '0.2'});
            }
        };

        $toggle.on('change', function() {
            var value = parseInt($('option:selected', $toggle).val(), 10);
            wrapper.$node.off('hover', overlayShadow);
            if (value) {
                self.setProp(wrapper.element, {opacity: '0.2'});
                wrapper.$node.on('hover', overlayShadow);
            } else {
                self.setProp(wrapper.element , {opacity: '1.0'});
            }
        }).trigger('change');
    });

    ImagePreview.prototype.previewCaptionHide = function() {
        $('.gallery-preview .grid-gallery-caption')
            .data('grid-gallery-type', 'none')
            .attr('data-grid-gallery-type', 'none');
        this.initCaptionEffects();
        $('#preview figcaption').hide();
    };

    ImagePreview.prototype.previewCaptionShow = function(fields) {
        var imgPreview = this;
        $('#preview figcaption').show();
        this.setDataset('figure', 'data-grid-gallery-type', $('#overlayEffect').val());

        $('#effectsPreview').find('figure:not(.available-in-pro)').bind('click', $.proxy(function (e) {
            this.setDataset('figure', 'data-grid-gallery-type', $(e.currentTarget).data('grid-gallery-type'));
        }, this)).trigger('change');

        $(getSelector(fields.bg)).bind('change', $.proxy(function (e) {
            var color = hexToRgb($(e.currentTarget).val());
            backgroundColor = 'transparent';
            if (color) {
                backgroundColor = 'rgba(' + color.r + ',' + color.g + ',' + color.b + ',' +
                    (1 - $(getSelector(fields.opacity)).val() / 10) + ')';
            }

            if(this.$window.find('figure').data('grid-gallery-type') == 'polaroid'){
                this.setProp('figcaption', {
                    backgroundColor: 'transparent'
                });
            } else {
                this.setProp('figcaption', {
                    backgroundColor: backgroundColor
                });
            }

            this.$window.trigger('updateCaptionBackground', backgroundColor);
        }, this)).trigger('change');

        $(getSelector(fields.fg)).bind('change', $.proxy(function (e) {
            this.setProp('figcaption', { color: $(e.currentTarget).val() });
        }, this)).trigger('change');

        function hexToRgb(hex) {
            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            } : null;
        }

        $(getSelector(fields.opacity)).bind('change', $.proxy(function (e) {
            $(getSelector(fields.bg)).trigger('change');
        }, this));

        $(getSelector(fields.size) + ',' + getSelector(fields.sizeUnit))
            .bind('change', $.proxy(function (e) {
                var $size = $(getSelector(fields.size)),
                    $unit = $(getSelector(fields.sizeUnit)),
                    unitValue = 'px';

                switch (parseInt($unit.val(), 10)) {
                    case 0:
                        unitValue = 'px';
                        break;
                    case 1:
                        unitValue = '%';
                        break;
                    case 2:
                        unitValue = 'em';
                        break;
                }

                this.setProp('figcaption', { fontSize: $size.val() + unitValue });
            }, this)).trigger('change');

        $(getSelector(fields.align)).on('change', $.proxy(function (e) {
            var value = '';

            if($(e.currentTarget).val() != 'auto') {
                value = $(e.currentTarget).val();
            }

            this.setProp('figcaption', { textAlign: value });
        }, this)).trigger('change');

        $(getSelector(fields.fontFamily)).on('change', $.proxy(function (e) {
            var fontFamily = $(getSelector(fields.fontFamily)).val();
			if(!fontFamily || fontFamily == 'Default') return;
            if(!window || !window.sggStandartFontsList || $.inArray(fontFamily.replace(/\"/g, ''), window.sggStandartFontsList) == -1) {
                imgPreview.importFontFamily(fontFamily);
            }
            this.setProp('figcaption', { fontFamily: '"' + fontFamily + '"' + ', serif' });
        }, this)).trigger('change');

        $(getSelector(fields.position)).on('change', $.proxy(function (e) {
            var position = $(getSelector(fields.position)).val();
            this.setProp('.grid-gallery-figcaption-wrap', { verticalAlign: position });
        }, this)).trigger('change');

        var hideFigcaptionTimer;
        $elements = $();
        for (var i in fields) {
            $.merge($elements, $(getSelector(fields[i])));
        };

        $elements.on('change keyup input paste', $.proxy(function () {
            self = this;
            $('#preview .grid-gallery-caption').addClass('hovered')
            clearTimeout(hideFigcaptionTimer);
            hideFigcaptionTimer = setTimeout(function() {
                $('#preview .grid-gallery-caption').removeClass('hovered');
            }, 3000);
        }, this));
    };

    ImagePreview.prototype.initCaption = (function () {
        var fields = {
            effect: 'thumbnail[overlay][effect]',
            position: 'thumbnail[overlay][position]',
            bg: 'thumbnail[overlay][background]',
            fg: 'thumbnail[overlay][foreground]',
            opacity: 'thumbnail[overlay][transparency]',
            size: 'thumbnail[overlay][text_size]',
            sizeUnit: 'thumbnail[overlay][text_size_unit]',
            align: 'thumbnail[overlay][text_align]',
            fontFamily: 'thumbnail[overlay][font_family]'
        },	selfIp = this;

		$('[name="thumbnail[overlay][enabled]"]').on('change', function(event) {
			var isCaptionBuilderEnabled = selfIp.callExtenedFunc('isCaptionBuilderEnabled', []);
			if(isCaptionBuilderEnabled) {
				selfIp.callExtenedFunc('initBackgroundEnableChangeHandler');
			} else {
				var isCaptionEnabled = event.target.value;
				if(isCaptionEnabled == 'true') {
					selfIp.previewCaptionShow(fields);
				} else {
					selfIp.previewCaptionHide();
				}
			}
		});
		$('[name="thumbnail[overlay][enabled]"]').off('ifChanged').on('ifChanged', function(event) {
			// code runnen twice
			var $overlayEnabled = $('[name="thumbnail[overlay][enabled]"]:checked');
			if($overlayEnabled.length) {
				selfIp.initCaptionsAndIcons();
			}
		});
    });

	//ImagePreview.prototype.getCssParamsForCaption = (function() {
	//
	//});

    ImagePreview.prototype.getCssParamsForIcons = (function(paramsToGet) {
		var returnObj = {};

		if(!paramsToGet || paramsToGet.effectName) {
			var $iconEffectName = $('#iconsEffectName');
			returnObj['effectName'] = $iconEffectName.val();
		}
		if(!paramsToGet || paramsToGet.color) {
			var	$iconsColor = $('#iconsColor');
			returnObj['color'] = $iconsColor.val();
		}
		if(!paramsToGet || paramsToGet.colorOnHover) {
			var $iconsHoverColor = $('#iconsHoverColor');
			returnObj['colorOnHover'] = $iconsHoverColor.val();
		}
		if(!paramsToGet || paramsToGet.bgColor) {
			var	$iconsBgColor = $('#iconsBackgroundColor');
			returnObj['bgColor'] = $iconsBgColor.val();
		}
		if(!paramsToGet || paramsToGet.bgColorOnHover) {
			var	$iconsHoverBgColor = $('#iconsBackgroundHoverColor');
			returnObj['bgColorOnHover'] = $iconsHoverBgColor.val();
		}
		if(!paramsToGet || paramsToGet.fontSize) {
			var	$iconsSize = $('#iconsSize');
			returnObj['fontSize'] = $iconsSize.val();
		}
		if(!paramsToGet || paramsToGet.distance) {
			var	$iconsDistance = $('#iconsMargin');
			returnObj['distance'] = $iconsDistance.val();
		}
		if(!paramsToGet || paramsToGet.overlayIsShowing) {
			var	$iconsOverlayIsShowed = $('#iconsOverlay');
			returnObj['overlayIsShowing'] = $iconsOverlayIsShowed.val();
		}

		if(!paramsToGet || paramsToGet.overlayColor) {
			var	$iconsOverlayColor = $('#iconsOverlayColor');
			returnObj['overlayColor'] = $iconsOverlayColor.val();
		}
		if(!paramsToGet || paramsToGet.overlayTransparency) {
			var	$iconsOverlayTransparency = $('#iconsOverlayTransparency')
			,	transpVal = parseInt($iconsOverlayTransparency.val());
			;
			if(!isNaN(transpVal)) {
				returnObj['overlayTransparency'] = 1 - (transpVal / 10);
			} else {
				returnObj['overlayTransparency'] = 1;
			}
		}
		return returnObj;
	});

	ImagePreview.prototype.initSimpleIcons = (function() {
		var selfIp = this
		,	$iconEffectName = $('#iconsEffectName')
		,	$iconsColor = $('#iconsColor')
		,	$iconsHoverColor = $('#iconsHoverColor')
		,	$iconsBgColor = $('#iconsBackgroundColor')
		,	$iconsHoverBgColor = $('#iconsBackgroundHoverColor')
		,	$iconsSize = $('#iconsSize')
		,	$iconsDistance = $('#iconsMargin')
		,	$figureIconsBlock = $('#preview .sggFigCaptionIconsEntry')
		;
		$iconEffectName.off('change').on('change', function() {
			selfIp.setIconParams($figureIconsBlock, {'effectName': $iconEffectName.val()});
		});
		$iconsColor.off('change').on('change', function() {
			selfIp.setIconParams($figureIconsBlock, {'color': $iconsColor.val()});
		});
		$iconsHoverColor.off('change').on('change', function() {
			selfIp.setIconParams($figureIconsBlock, {'colorOnHover': $iconsHoverColor.val()});
		});
		$iconsBgColor.off('change').on('change', function() {
			selfIp.setIconParams($figureIconsBlock, {'bgColor': $iconsBgColor.val()});
		});
		$iconsHoverBgColor.off('change').on('change', function() {
			selfIp.setIconParams($figureIconsBlock, {'bgColorOnHover': $iconsHoverBgColor.val()});
		});
		$iconsSize.off('change keyup paste').on('change keyup paste', function() {
			selfIp.setIconParams($figureIconsBlock, {'fontSize': $iconsSize.val()});
		});
		$iconsDistance.off('change keyup paste').on('change keyup paste', function() {
			selfIp.setIconParams($figureIconsBlock, {'distance': $iconsDistance.val()});
		});
	});

	ImagePreview.prototype.initSimpleOverlay = (function($simpleOverlayBlock) {
		var	$iconsOverlayIsShowed = $('#iconsOverlay')
		,	$iconsOverlayTransparency = $('#iconsOverlayTransparency')
		,	$iconsOverlayColor = $('#iconsOverlayColor')
		,	selfIp = this
		;
		$iconsOverlayIsShowed.off('change').on('change', function() {
			selfIp.setSimpleOverlay($simpleOverlayBlock, {
				'overlayIsShowing': $iconsOverlayIsShowed.val(),
				'overlayColor': $iconsOverlayColor.val(),
				'overlayTransparency': $iconsOverlayTransparency.val(),
			});
		});
		$iconsOverlayColor.off('change').on('change', function() {
			selfIp.setSimpleOverlay($simpleOverlayBlock, {
				'overlayIsShowing': $iconsOverlayIsShowed.val(),
				'overlayColor': $iconsOverlayColor.val(),
				'overlayTransparency': $iconsOverlayTransparency.val(),
			});
		});
		$iconsOverlayTransparency.off('change').on('change', function() {
			selfIp.setSimpleOverlay($simpleOverlayBlock, {
				'overlayIsShowing': $iconsOverlayIsShowed.val(),
				'overlayColor': $iconsOverlayColor.val(),
				'overlayTransparency': $iconsOverlayTransparency.val(),
			});
		});
	});

	ImagePreview.prototype.setSimpleOverlay = (function($overlayBlock, paramsToGet) {
		var isOverlayShow
		,	color
		,	transpVal
		,	notSetted = true
		;
		if(!$overlayBlock || !$overlayBlock.length) {
			$overlayBlock = $('#preview .grid-gallery-caption')
		}
		if(paramsToGet && paramsToGet.overlayIsShowing == 'true' && paramsToGet.overlayColor) {
			transpVal = parseInt(paramsToGet.overlayTransparency);
			if(!isNaN(transpVal)) {
				transpVal = 1 - (transpVal / 10);
				color = hexToRgbA(paramsToGet.overlayColor, transpVal);
				$overlayBlock.css({'background-color': color});
				notSetted = false;
			}
		}

		if(notSetted) {
			$overlayBlock.css({'background-color': 'transparent'});
		}
	});

	ImagePreview.prototype.setIconParams = (function($iconWrapper, params) {
		var $iconList = $iconWrapper.find('.hi-icon');

		if(params) {
			if(params.effectName) {
				var oldClassArr = this.findClassByStr($iconWrapper, 'hi-icon-effect')
				,	tmpVal = params.effectName;
				for(var indTmpInd = 0; indTmpInd < oldClassArr.length; indTmpInd++) {
					$iconWrapper.removeClass(oldClassArr[indTmpInd]);
				}

				$iconWrapper.addClass(tmpVal);
				tmpVal = tmpVal.substr(0, tmpVal.length - 1);
				$iconWrapper.addClass(tmpVal);
			}
			if(params.distance) {
				var distance = parseInt(params.distance);
				if(!isNaN(distance)) {
					$iconList.each(function(ind, item) {
						var $currItem = $(item);
						$currItem.css({
							'margin-left': distance + 'px',
							'margin-right': distance + 'px',
						});
					});
				}
			}
			if(params.color) {
				$('#sggSettingsIconColorStyle').html('.hi-icon {color: ' + params.color + ' !important;}');
			}
			if(params.colorOnHover) {
				$('#sggSettingHiIconHoverColorStyle').html('.hi-icon:hover { color: ' + params.colorOnHover + ' !important; }');
			}
			if(params.bgColor) {
				$('#sggSettingsIconBgColorStyle').html('.hi-icon { background: ' + params.bgColor + ' !important; }');
			}
			if(params.bgColorOnHover) {
				$('#sggSettingHiIconHoverBgStyle').html('.hi-icon:hover { background: ' + params.bgColorOnHover + ' !important; }');
			}
			if(params.fontSize) {
				var fontSize = parseInt(params.fontSize);
				if(!isNaN(fontSize)) {
					$('#sggSettingHiIconBeforeFontSizeStyle').html(
						'.hi-icon:before {font-size: ' + fontSize + 'px !important;' +
						'line-height: ' + 2*fontSize + 'px !important;}'
					);
					$('#sggSettingsIconSizeStyle').html(
						'.hi-icon {width: ' + 2*fontSize + 'px !important;' +
						'height: ' + 2*fontSize + 'px !important;}'
					);
				}
			}
		}
	});

    ImagePreview.prototype.initCaptionsAndIcons = (function() {
		var captBuilderEnabled = $('input.ggUserCaptionBuilderCl:checked').val() == 1
		,	captionEnabled = $('input[name="thumbnail[overlay][enabled]"]:checked').val() == 'true'
		,	iconsEnabled = $('input[name="icons[enabled]"]:checked').val() == 'true'
		,	$preview = $('#preview')
		,	$iconsOverlayIsShowed = $('#iconsOverlay')
		,	$iconsOverlayTransparency = $('#iconsOverlayTransparency')
		,	$iconsOverlayColor = $('#iconsOverlayColor')
		,	$figure = $preview.find('.grid-gallery-caption')
		// when use Icons and Captions then added 2nd block for effects
		,	$figureNewCaptionBlock = $figure.find('.sggCcBlockAfter')
		,	$figureIconsBlock = $figure.find('.sggFigCaptionIconsEntry')
		,	$figureCaptionBlock = $figure.find('.sggFigcaptionCaptionWrapper')
		,	$figcaptionBlock = $figure.find('figcaption')
		,	effectCode = $('#overlayEffect').val()
		,	previewInited = false
		,	selfIp = this
		;
		if(!captBuilderEnabled) {
			if(captionEnabled && iconsEnabled) {

				if(['icons-sodium-left', 'icons-sodium-top'].indexOf(effectCode) != -1) {
					// additional panel in figure
					$figureNewCaptionBlock.removeClass('ggSettingsDisplNone');
					$figureIconsBlock.removeClass('ggSettingsDisplNone');
					$figureCaptionBlock.addClass('ggSettingsDisplNone');

					var iconSetts = this.getCssParamsForIcons(false)
					,	oldClassObjArr = this.findClassByStr($figureNewCaptionBlock, 'caption-with-');
					selfIp.setIconParams($figureIconsBlock, iconSetts);

					if(!selfIp.isInitSimpleIcons) {
						selfIp.initSimpleIcons();
						selfIp.isInitSimpleIcons = 1;
					}
					if(!selfIp.isInitSimpleOverlay) {
						selfIp.initSimpleOverlay($figcaptionBlock);
						selfIp.isInitSimpleOverlay = 1;
					}

					// first init BgColor
					selfIp.setSimpleOverlay($figcaptionBlock, {
						'overlayIsShowing': $iconsOverlayIsShowed.val(),
						'overlayColor': $iconsOverlayColor.val(),
						'overlayTransparency': $iconsOverlayTransparency.val(),
					});
					// remove old class and set new
					for(var indTmpInd = 0; indTmpInd < oldClassObjArr.length; indTmpInd++) {
						$figureNewCaptionBlock.removeClass(oldClassObjArr[indTmpInd]);
					}
					$figureNewCaptionBlock.addClass('caption-with-' + effectCode);
					previewInited = true;
				} else {
					$figureNewCaptionBlock.addClass('ggSettingsDisplNone');
					$figureIconsBlock.addClass('ggSettingsDisplNone');
					$figureCaptionBlock.removeClass('ggSettingsDisplNone');
				}
			} else {
				$figureNewCaptionBlock.addClass('ggSettingsDisplNone');
				$figureIconsBlock.addClass('ggSettingsDisplNone');
				$figureCaptionBlock.removeClass('ggSettingsDisplNone');
				$figcaptionBlock.show();
				$figcaptionBlock.removeClass('ggSettingsTop0');
				if(captionEnabled) {

				} else if(iconsEnabled) {
					$figureIconsBlock.removeClass('ggSettingsDisplNone');
					$figureCaptionBlock.addClass('ggSettingsDisplNone');
					$figcaptionBlock.addClass('ggSettingsTop0');
					// set bg
					selfIp.setSimpleOverlay($figcaptionBlock, {
						'overlayIsShowing': $iconsOverlayIsShowed.val(),
						'overlayColor': $iconsOverlayColor.val(),
						'overlayTransparency': $iconsOverlayTransparency.val(),
					});
				} else {
					$figcaptionBlock.hide();
				}
			}
		}
		$('input[name="icons[enabled]"]').off('ifChanged').on('ifChanged', function(event) {
			// runned twice
			var $checkedElem = $('input[name="icons[enabled]"]:checked');
			if($checkedElem.length) {
				selfIp.initCaptionsAndIcons();
			}
		});
		return previewInited;
	});

	ImagePreview.prototype.init = (function () {
		var selfIp = this;
		//this.$window.draggable();
		this.initBorder();
		this.initShadow();
		this.initMouseShadow();
		this.initOverlayShadow();
		this.initSharedPropsForIcons();

		if(typeof this.previewSettingsKeys == 'undefined') {
			this.previewSettingsKeys = {};
		}
		this.objectsData = new sggDataSelectorsCache();
		this.objectsData.init({
			'keys': this.previewSettingsKeys,
		});

		// ???
		this.initCaption();
		this.initCaptionEffects();

		this.initCaptionsAndIcons();
    });

    ImagePreview.prototype.captionCalculations = (function() {
        var heightRecalculate = function() {
            var figcaption = $('div#preview > figure > figcaption'),
                captionStyle = {
                    'height': figcaption.innerHeight(),
                    'display': 'table'
                },
                wrap = figcaption.find('div.grid-gallery-figcaption-wrap');
            figcaption.css(captionStyle);
            wrap.css('display', 'table-cell');
        };
        $('div#preview > figure').on('change', function() {
            heightRecalculate();
        });
    });

    ImagePreview.prototype.checkDirection = function($element, e) {
        var w = $element.width(),
            h = $element.height(),
            x = ( e.pageX - $element.offset().left - ( w / 2 )) * ( w > h ? ( h / w ) : 1 ),
            y = ( e.pageY - $element.offset().top - ( h / 2 )) * ( h > w ? ( w / h ) : 1 );

        return Math.round(( ( ( Math.atan2(y, x) * (180 / Math.PI) ) + 180 ) / 90 ) + 3) % 4;
    };

    ImagePreview.prototype.getCssFromString = (function(cssString) {
        var propArr = [];
        if(cssString && cssString.split) {
            var arrStyle = cssString.split(';');
            if(arrStyle.length) {
                for(var indA1 in arrStyle) {
                    var strTemp = arrStyle[indA1].trim();
                    if(strTemp.length) {
                        var oneStyleArr = strTemp.split(':');
                        if(oneStyleArr.length == 2) {
                            propArr[oneStyleArr[0].trim()] = oneStyleArr[1].trim();
                        }
                    }

                }
            }
        }
        return propArr;
    });

    ImagePreview.prototype.objectToCssString = (function(styleArr) {
        var cssString = ''
        ,   objectKeys = Object.keys(styleArr);

        if(objectKeys.length) {
            for(var indA1 in objectKeys) {
                cssString += objectKeys[indA1] + " : " + styleArr[objectKeys[indA1]] + "; ";
            }
        }
        return cssString;
    });

    ImagePreview.prototype.initCaptionEffects = (function () {
        var self = this, figure = $('#preview figure.grid-gallery-caption');
        figure.find('figcaption').css('height', '100%');

		if(figure.attr('data-grid-gallery-type') == 'polaroid') {
			if (!this.defaultStyles) {
				this.defaultStyles = {
					figureStyle: figure.attr('style'),
					imageStyle: figure.find('img').attr('style')
				}
			};
		} else {
			// get preview figure params
			var figureWithStyle = $("#preview figure.grid-gallery-caption")
			,	imageStyleObj = self.getCssFromString(figureWithStyle.find('img').attr('style'));
			// remove image size properties
			if(imageStyleObj['height']) {
				delete imageStyleObj['height'];
			}
			if(imageStyleObj['width']) {
				delete imageStyleObj['width'];
			}
			this.defaultStyles = {
				figureStyle: figureWithStyle.attr('style'),
				imageStyle: self.objectToCssString(imageStyleObj),
			}
		}
        figure.each(function() {
			$(this).removeAttr('style').attr('style', self.defaultStyles.figureStyle);
			$(this).find('img').removeAttr('style').attr('style', self.defaultStyles.imageStyle);

            if(!$(this).find('.polaroid-bg-wrap').length){
                $(this).find('img').wrap('<div class="polaroid-bg-wrap">');
            }
            // $(this).off('mouseenter mouseleave');
            $(this).find('figcaption').removeClass();
            $(this).off('mouseenter mouseleave');

            if ($(this).data('grid-gallery-type') == 'cube') {
                $(this).on('mouseenter mouseleave', function(e) {
                    var $figcaption = $(this).find('figcaption'),
                        direction = self.checkDirection($(this), e),
                        classHelper = null;

                    switch (direction) {
                        case 0:
                            classHelper = 'cube-' + (e.type == 'mouseenter' ? 'in' : 'out') + '-top';
                            break;
                        case 1:
                            classHelper = 'cube-' + (e.type == 'mouseenter' ? 'in' : 'out') + '-right';
                            break;
                        case 2:
                            classHelper = 'cube-' + (e.type == 'mouseenter' ? 'in' : 'out') + '-bottom';
                            break;
                        case 3:
                            classHelper = 'cube-' + (e.type == 'mouseenter' ? 'in' : 'out') + '-left';
                            break;
                    }
                    $figcaption.removeClass()
                        .addClass(classHelper);
                });
            }

            if ($(this).data('grid-gallery-type') == 'polaroid' &&
                $(this).closest('#preview').length > 0) {

				var $img = $(this).find('img')
				,	$galleryType = $('select[name="area[grid]"]')
				,	$imgGalleryWidth = $('input[name="area[photo_width]"]')
				,	$imgGalleryHeight = $('input[name="area[photo_height]"]')
				,	realImgHeight = $img[0].naturalHeight
				,	realImgWidth = $img[0].naturalWidth
				,	scaleRatio = realImgWidth / realImgHeight
				,	frameWidth = parseInt($('.caption-type[data-gg-cb-type="captions-icons"] [name="thumbnail[overlay][polaroidFrameWidth]"]').val())
				,	$figcaption = $(this).find('figcaption')
				,	$polaroidWrapper = $('.polaroid-bg-wrap')
				,	imageWidth
				,	imageHeight
                ,   builderHeight = $('input[name="captionBuilder[title][height]"]')
				,   captionHeight = builderHeight.length ? builderHeight.val() : 0
				,   clearHeight = captionHeight ? parseInt(captionHeight.toString().match(/\d.?\d*.?\d*/)[0]) : 0
				,   figcaptionHeight = 0
				;

				if($galleryType.val() == 2) {
					// only image height
					//imageHeight = parseInt($polaroidWrapper.outerHeight());
					//imageWidth = imageHeight * scaleRatio;
					//// cal width with border
					//imageWidth = imageWidth - (2*frameWidth);
					//imageHeight = imageWidth/scaleRatio;
					imageWidth = parseInt($polaroidWrapper.outerWidth()) - (frameWidth*2);
					imageHeight = imageWidth / scaleRatio;
				} else {
					imageWidth = parseInt($polaroidWrapper.outerWidth()) - (frameWidth*2);
					imageHeight = imageWidth / scaleRatio;
				}
				if(!isNaN(clearHeight) && clearHeight != 0) {
					figcaptionHeight = (captionHeight.toString().indexOf('%') > 0 ? (imageHeight * clearHeight / 100) : clearHeight) + 'px';
				}
				$(this).find('.gg-caption-table').css('height', '1px');
				$(this).find('.gg-caption-row').css({'max-height': figcaptionHeight ? figcaptionHeight : '100%', 'height': 'auto'});
				$figcaption.css({'background': 'none', 'height': figcaptionHeight});


				$img[0].style.setProperty('width', imageWidth + 'px', 'important');
				$img[0].style.setProperty('height', imageHeight + 'px', 'important');
                $img[0].style.setProperty('margin', '0 auto', 'important');
                $img[0].style.setProperty('padding-top', frameWidth + 'px', 'important');
                $img[0].style.setProperty('padding-bottom', frameWidth + 'px', 'important');

                $(this).css({
                    'width': $(this).width(),
                });

                //$figcaption.css('padding', frameWidth + 'px');

				var $backgroundColor = $('input[name="thumbnail[overlay][background]"]').val()
				,	$transparency = $('select[name="thumbnail[overlay][transparency]"]').val()
				,	css = hexToRgbA($backgroundColor, (10 - $transparency)/10);

				$(this).css({
					'background-color': css
				});
				//$(this).find('figcaption').css({'background': 'none'});

                if ($('#polaroid-scattering select').val() == 'true') {
                    $(this).css({
                        'transform': 'rotate(' + (-3 + Math.random() * (10 - 3)) + 'deg)'
                    });
                    $('#preview .grid-gallery-caption').addClass('polaroid-scattering');
                } else {
                    $('#preview .grid-gallery-caption').removeClass('polaroid-scattering');
                }

                if ($('#polaroid-animation select').val() == 'true') {
                    $('#preview .grid-gallery-caption').addClass('polaroid-animation');
                } else {
                    $('#preview .grid-gallery-caption').removeClass('polaroid-animation');
                }
                if(builderHeight.length == 0) {
                    $figcaption.css('height', 'auto');
                }
            }else{
				var $backgroundColor = $('input[name="thumbnail[overlay][background]"]').val()
				,	$transparency = $('select[name="thumbnail[overlay][transparency]"]').val()
				,	css = hexToRgbA($backgroundColor, transparencyConvert[$transparency] );

				$(this).find('figcaption').css({'background-color': css});

                var topRow = $(this).find('.gg-caption-row.top'),
                    centerRow = $(this).find('.gg-caption-row.center');
                if(centerRow.length == 1) {
                    if(topRow.length == 1) centerRow.css({'top': topRow.height(), 'transform': 'initial'});
                    else centerRow.css({'top': '50%', 'transform': 'translateY(-50%)'});
                }
			}
        });
    });

	ImagePreview.prototype.callExtenedFunc = (function(funcName, funcParams) {
		// is settings exists
		if(this.initCurrSettingsPro) {
			if(this.constructor.prototype[funcName]) {
				if(!funcParams) {
					funcParams = [];
				}
				return this.constructor.prototype[funcName].call(this, funcParams);
			} else {
				console.log("Error! Can't find function: " + funcName);
			}
		}
		return null;
	});

	ImagePreview.prototype.getCaptionObjectByKey = (function(key) {
		// is @key string ?
		if(key.trim) {
			return this.objectsData.get(key);
		} else {
			return this.objectsData.getFromArray(key);
		}
	});

	ImagePreview.prototype.getPreviewRowObjectByCode = (function(code) {
		var $rowObject = null;

		$rowObject = this.callExtenedFunc('getPreviewRowObjectByCodePro', code)
		return $rowObject;
	});

	ImagePreview.prototype.findClassByStr = (function($element, codeStr) {
		var res = [];
		if($element && $element.length) {
			if ($element[0].classList && $element[0].classList.length) {
				var classList = $element[0].classList
					,	ind2 = 0;
				while(ind2 < classList.length) {
					if(classList[ind2].indexOf(codeStr) != -1) {
						res.push(classList[ind2]);
					}
					ind2++;
				}
			}
		}
		return res;
	});

	ImagePreview.prototype.setStyleByArrayCodes = (function(objectCode, styleCodesObject) {
		var codeList = Object.keys(this.previewSettingsKeys);
		if(objectCode &&  codeList.indexOf(objectCode) != -1) {
			var stylesKeys = [];

			if(styleCodesObject) {
				stylesKeys = Object.keys(styleCodesObject);
			} else {
				stylesKeys = Object.keys(this.previewSettingsKeys[objectCode]);
			}
			this.callExtenedFunc('setStyleByArrayCodesPro', [stylesKeys, objectCode, styleCodesObject])
		}
	});

    $(document).ready(function () {

        jQuery('#importDialog').on('click' , 'button.disabled', function (e) {
            e.preventDefault();
            document.location = $(this).data('src');
        });

        jQuery('input#cmn-preview').click(function() {
            if($(this).is(':checked')) {
                jQuery('#preview figure').show();
            } else {
                jQuery('#preview figure').hide();
            }
        });

        Gallery.ImagePreview = new ImagePreview(true);
		$(document).trigger('sggInitGalleryImagePreviewPro', Gallery.ImagePreview);

		Gallery.sggDataSelectorsCache = sggDataSelectorsCache;

		// Init Caption: run only on One time
		$('[name="thumbnail[overlay][enabled]"]:checked').trigger('change');
		setTimeout(function() {
			$('input[name="icons[enabled]"]:checked').trigger('ifChanged');
		}, 100);
    });

	/* NOW its unusable Code created for mosaic[images][count]
    $("input[type=number]").each(function($index){
        if(this.hasAttribute('min')){
            var item = $(this);
            item.on('change', function($event){
                var max = parseInt($(this).attr('max'));
                if(isNaN(max)){
                    max = Number.MAX_SAFE_INTEGER;
                }
                var min = parseInt($(this).attr('min'));
                if ($(this).val() > max) {
                    $(this).val(max);
                }
                else if ($(this).val() < min) {
                    $(this).val(min);
                }
            });
        }
    });
	/**/

}(jQuery, window.SupsysticGallery = window.SupsysticGallery || {}));


function hexToRgbA(hex, transparent){
	var c;
	if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
		c= hex.substring(1).split('');
		if(c.length== 3){
			c= [c[0], c[0], c[1], c[1], c[2], c[2]];
		}
		c= '0x'+c.join('');
		return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+','+transparent+')';
	}else{
		return 'rgba(111,0,0,0.5)';
	}
}

var transparencyConvert = {
	'0': '0.1',
	'1': '0.2',
	'2': '0.3',
	'3': '0.3',
	'4': '0.4',
	'5': '0.5',
	'6': '0.6',
	'7': '0.7',
	'8': '0.8',
	'9': '0.9',
	'10': '1',
};

(function($)
{
	$.fn.removeStyle = function(style)
	{
		var search = new RegExp(style + '[^;]+;?', 'g');

		return this.each(function()
		{
			$(this).attr('style', function(i, style)
			{
				return style && style.replace(search, '');
			});
		});
	};
}(jQuery));