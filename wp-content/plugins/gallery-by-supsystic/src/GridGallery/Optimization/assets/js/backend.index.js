(function($, ajaxurl) {

	function ImageOptimize() {
		this.initImageOptimizeTabPage();
	}

	ImageOptimize.prototype.initOptimizeButton = (function(initHanlder, completeHandler) {
		var self = this;

		self.$dialogWindow = $('.sgg-io-tabs-list.sgg-il-optimize-dlg-wnd');
		// prepare tabs for popup WND
		sggOptimizeInitTabsFor('.sgg-il-optimize-dlg-wnd');
		//init Dialog wnd
		sggOptimizeInitDialogWnd(self.$dialogWindow, {
			'maxHeight': Math.floor(jQuery(window).height()*0.9),
			'close' : function() {
				if(self.$dialogWindow.currAjaxSend) {
					self.$dialogWindow.currAjaxSend.abort();
					self.$dialogWindow.currAjaxSend = false;
				}
			}
		});
		// manually add class
		self.$dialogWindow.parent().addClass('sgg-dlg-wnd-zindex');
		self.$dialogWindow.completeHandler = completeHandler;

		$('.sgg-il-optimize-again-btn').off('click').on('click', function() {
			self.prepareOptimizeProcessWnd();
		});

		this.$optimizeButton.off('click').on('click', function() {
			if(initHanlder && typeof initHanlder == 'function') {
				initHanlder();
			}
			//init start values
			var imgCount = parseInt(self.$optimizeButton.attr('data-gallery-img-cnt'), 10),
				$imgSizeText = $("#sgg-il-optimize-preview");
			$('.sgg-il-preview-img-cnt, .sgg-il-original-img-cnt').text(imgCount);
			$('#sgg-il-amount-img-cnt').text(2*imgCount);

			$('#sgg-il-gallery-size').text(self.$optimizeButton.attr('data-gallery-total-size'));
			if(self.$optimizeButton.attr('data-gallery-total-size') == '-') {
				$('#sgg-iop-totalrow').addClass('sgg-io-tab-hidden');
			} else {
				$('#sgg-iop-totalrow').removeClass('sgg-io-tab-hidden');
			}
			$('#sgg-il-gallery-units').text(self.$optimizeButton.attr('data-gallery-units'));

			// set dialog params
			self.$dialogWindow.dialog("option", "width", 400);
			self.$dialogWindow.dialog("option", "title", $('#sgg-transl-img-opt-1').val());
			self.$dialogWindow.dialog( "option", "buttons", [
				{
					'text': $("#sgg-transl-start-opt-1").val(),
					'disabled': 'disabled',
					'id': 'sgg-il-startOptimize',
					'click': function() {
						self.prepareOptimizeProcessWnd();
					},
				},
				{
					'text': 'Cancel',
					'id': 'sgg-dlg-optimize-cancel',
					'click': function () {
						$(this).dialog('close');
					},
				},
				{
					'text': 'Ok',
					'id': 'sgg-dlg-optimize-ok',
					'click': function () {
						$(this).dialog('close');
					},
				},
			]);

			var authData = self.$optimizeButton.attr('data-auth');
			if(authData) {
				var authButtonData = JSON.parse(authData);
				if(authButtonData && authButtonData['current'] && authButtonData['setting'] && authButtonData['setting'][authButtonData['current']]) {
					self.serviceCode = authButtonData['current'];
					self.serviceAuthData = authButtonData['setting'][self.serviceCode];
					self.serviceName = self.getServiceNameByCode(self.serviceCode);
					if(self.serviceName && self.serviceCode == 'tinypng' &&  self.serviceAuthData.auth_key) {
						$('#sgg-il-startOptimize').prop("disabled", false);
					}
				}
			}
			// open first tab
			$('.sgg-io-tab-link[data-tab-id="sgg-il-optimize-start"]').trigger('click');
			self.$dialogWindow.dialog('open');
			$('#sgg-il-startOptimize').removeClass('sgg-io-tab-hidden');
			$('#sgg-dlg-optimize-cancel').removeClass('sgg-io-tab-hidden');
			$('#sgg-dlg-optimize-ok').addClass('sgg-io-tab-hidden');
		});
	});

	ImageOptimize.prototype.prepareOptimizeProcessWnd = (function() {

		var $optimizeInfo = $(".sgg-optimize-info")
		,	self = this
		,	isCheckPreview = ($("#sgg-il-optimize-preview").is(':checked') ? '1': null);
		$optimizeInfo.addClass('sgg-io-tab-hidden');
		// hide error text
		$('.sgg-opt-info-error').addClass('sgg-io-tab-hidden');

		// show image text about preview
		$('.sgg-iop-without-prev, .sgg-iop-with-prev').addClass('sgg-io-tab-hidden');
		if(isCheckPreview == 1) {
			$('.sgg-iop-with-prev').removeClass('sgg-io-tab-hidden');
		} else {
			$('.sgg-iop-without-prev').removeClass('sgg-io-tab-hidden');
		}

		// set dialog width
		self.$dialogWindow.dialog("option", "width", 400);
		self.$dialogWindow.dialog("option", "title", $('#sgg-transl-img-opt-2').val());
		$('#sgg-il-startOptimize').addClass('sgg-io-tab-hidden');
		$('#sgg-dlg-optimize-cancel').removeClass('sgg-io-tab-hidden');
		$('#sgg-dlg-optimize-ok').addClass('sgg-io-tab-hidden');
		// translate tab to step "Optimization Process"
		$('.sgg-io-tab-link[data-tab-id="sgg-il-optimize-process"]').trigger('click');

		var data =  {
			'optimize-preview': isCheckPreview,
			'galleries': JSON.parse(this.$optimizeButton.attr('data-gallery-ids')),
		};
		// loading gallery image list
		var request = SupsysticGallery.Ajax.Post({
			module: 'optimization',
			action: 'getPhotoList',
			data: data,
		});

		$.jGrowl("Prepare information for Gallery optimize...");
		request.send(function (response) {
			if (response && response.success == true && response.photos && response.galleryInfo) {
				self.optimizeProcess($optimizeInfo, response.galleryInfo, response.photos);
			} else {
				$.jGrowl('Error ocurred');
			}
		}).fail(function () {
			$.jGrowl('Error ocurred');
		});
	});

	ImageOptimize.prototype.optimizeProcess = (function($optimizeInfo, galleryInfo, photos) {
		var self = this
		,	keys = Object.keys(galleryInfo);
		if(photos && keys.length) {
			var currGall = 0
			,	countGall = keys.length
			,	currPhoto = 0
			,	countPhoto = 0
			,	isRestore = ($("#sgg-il-backup-img-src").is(':checked') ? '1' : null)
			,	ajaxPromise = new $.Deferred().resolve()
			,	oneRequest
			,	urlLogList = []
			,	currLogInd = 0
			,	serviceError = false;
			self.$dialogWindow.currAjaxSend = false;
			galleryInfo.serviceCode = self.serviceCode;
			galleryInfo.isRestore = isRestore;

			if(photos[keys[0]]) {
				countPhoto = photos[keys[0]].length;
			}
			$("#sgg-conn-to-serv-name").text(self.serviceName);
			this.setOptimizeInfo(currGall + 1, countGall, currPhoto, countPhoto);
			$optimizeInfo.removeClass('sgg-io-tab-hidden');

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
				currGall++;
			};

			function processOneOptimizeImage(currIndex, logObject) {
				oneRequest = SupsysticGallery.Ajax.Post({
					module: 'optimization',
					action: 'optimizeOneImage',
					data: {
						'currentServiceCode': self.serviceCode,
						'auth_data': self.serviceAuthData,
						'restoreSrc': isRestore,
						'url': logObject.url,
					},
				});

				self.$dialogWindow.currAjaxSend = oneRequest.send(function(opResponse) {
					self.setOptimizeInfo(logObject.gInd + 1, logObject.gCount, logObject.iInd+1, logObject.iCount);
					if(opResponse) {
						if(!opResponse.success) {
							$.jGrowl(opResponse.message ? opResponse.message: "Unknown Error!");
						}
						if(opResponse.imgInfo) {
							logObject.imgInfo = opResponse.imgInfo;
						}
						if(opResponse.serviceError) {
							serviceError = true;
                            $('.sgg-opt-info-error').children("span").text(opResponse.message);
							$('.sgg-opt-info-error').removeClass('sgg-io-tab-hidden');
						}
					}
					if(currIndex == currLogInd-1) {
						self.prepareOptimizeLogWnd(galleryInfo,  urlLogList);
					}
				}).fail(function (opResponse, statusText) {
					self.setOptimizeInfo(logObject.gInd + 1, logObject.gCount, logObject.iInd+1, logObject.iCount);
					if(currIndex == currLogInd-1 && statusText != "abort") {
						self.prepareOptimizeLogWnd(galleryInfo, urlLogList);
					}
				});
				return self.$dialogWindow.currAjaxSend;
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
					}
				});
			});
		}
	});

	ImageOptimize.prototype.getServiceNameByCode = (function(code) {
		var name = null;
		if(code == 'tinypng') {
			name = 'TinyPNG';
		}
		return name;
	});

	ImageOptimize.prototype.setOptimizeInfo = (function(galleryCurr, galleryCount, imgCurr, imgCount) {
		$("#sgg-opt-curr-gallery").text(galleryCurr);
		$("#sgg-opt-numb-gallery").text(galleryCount);
		$("#sgg-opt-curr-img").text(imgCurr);
		$("#sgg-opt-numb-imgs").text(imgCount);
	});

	ImageOptimize.prototype.prepareOptimizeLogWnd = (function(optParams, imgList) {

		var optimizeSize = 0.0
		,	previousSize = 0.0
		,	ind
		,	oneImg
		,	self = this
		,	$compareImgWrap = $('.sgg-iores-compare-wrap')
		,	$linkToImgShow = $('.sgg-iores-link-compare')
		,	htmlImgRows = ''
		,	galleryIndArray = [];

		if(imgList && imgList.length) {

			for(ind in imgList) {
				oneImg = imgList[ind];
				// if not error for this image
				if(oneImg.imgInfo) {
					if(oneImg.imgInfo.optSize && oneImg.imgInfo.restoreSize) {
						optimizeSize += parseFloat(oneImg.imgInfo.optSize);
						previousSize += parseFloat(oneImg.imgInfo.restoreSize);
					}
					if(oneImg.url) {
						htmlImgRows += self.prepareOptimizeCompareImgRow(oneImg.imgInfo.restoreUrl, oneImg.url, oneImg.imgInfo.restoreSize, oneImg.imgInfo.optSize)
					}
					if(optParams[oneImg.gId]) {
						optParams[oneImg.gId].imgCount = oneImg.iCount;
					}

					if(galleryIndArray.indexOf(oneImg.gId) == -1) {
						galleryIndArray.push(oneImg.gId);
					}
				}
			}
			// if not error
			if(htmlImgRows != '') {
				optParams.optimizePreview = ($("#sgg-il-optimize-preview").is(':checked') ? true : null);
				// save data to optimize table
				self.saveOptimizeInfoToDb(optParams);
			}
		}
		$('.sgg-iores-tsizebefore').text( Math.floor(previousSize*100)/100 );
		$('.sgg-iores-tsizeafter').text( Math.floor(optimizeSize*100)/100 );
		if(previousSize != 0) {
			$('.sgg-iores-tsaving').text(Math.floor( (100 - optimizeSize*100/previousSize) ));
		} else {
			$('.sgg-iores-tsaving').text(0);
		}

		// if not error
		if(htmlImgRows != '') {
			$compareImgWrap
				.html($('.sgg-iores-cmp-template').html())
				.append(htmlImgRows);
		} else {
			$compareImgWrap.html();
		}

		if(self.$dialogWindow.completeHandler && galleryIndArray.length) {
			self.$dialogWindow.completeHandler(galleryIndArray, optParams);
		}

		$('#sgg-dlg-optimize-cancel').addClass('sgg-io-tab-hidden');
		$('#sgg-dlg-optimize-ok').removeClass('sgg-io-tab-hidden');

		self.$dialogWindow.dialog("option", "title", $('#sgg-transl-img-opt-3').val());
		$('.sgg-io-tab-link[data-tab-id="sgg-il-optimize-result"]').trigger('click');

		// configure dialog wnd
		if(!this.isCompareLinkImgShowInited) {
			var prevWidth = this.$dialogWindow.dialog( "option", "width" );

			$linkToImgShow.off('click').on('click', function(subEvent){
				subEvent.preventDefault();
				if($compareImgWrap.hasClass('sgg-io-tab-hidden')) {
					if(jQuery('.supsystic-container').outerWidth()) {
						self.$dialogWindow.dialog("option", "width", jQuery('.supsystic-container').outerWidth());
					}
					$compareImgWrap.removeClass('sgg-io-tab-hidden');
				} else {
					self.$dialogWindow.dialog("option", "width", prevWidth);
					$compareImgWrap.addClass('sgg-io-tab-hidden');
				}
			});
			this.isCompareLinkImgShowInited = true;
		} else {
			$compareImgWrap.addClass('sgg-io-tab-hidden');
			self.$dialogWindow.dialog("option", "width", 400);
		}
	});

	ImageOptimize.prototype.saveOptimizeInfoToDb = (function(optimizeParams) {
		var request = SupsysticGallery.Ajax.Post({
			module: 'optimization',
			action: 'saveOptimizeInfoToDb',
			data: optimizeParams,
		});
		// nothing to show
		request.send(function (response) {});
	});

	ImageOptimize.prototype.prepareOptimizeCompareImgRow = (function (urlL, urlR, sizeL, sizeR) {
		var oneRow =
			'<div class="supsystic-io-block-row">'
			+ '<div class="supsystic-io-block-cell sgg-iores-img-cell">';

		if(urlL && urlL != '') {
			oneRow += '<img src="' + urlL + '" class="sgg-iores-img" alt="img_left"/>';
		}
		oneRow += '<div class="sgg-iores-img-txt">' + sizeL + ' Mb</div></div>'
			+ '<div class="supsystic-io-block-cell sgg-iores-img-cell">'
			+ '<img src="' + urlR + '" class="sgg-iores-img" alt="img_left"/>'
			+ '<div class="sgg-iores-img-txt">' + sizeR + ' Mb</div></div></div>';
		return oneRow;
	});

	// ## Tab PAGE
	ImageOptimize.prototype.initImageOptimizeTabPage = (function() {
		this.prepareSetupButtons();
		sggOptimizeInitTabsFor('.sgg-main-tab-anch');
		sggOptimizeInitTabsFor('.sgg-io-stat-anch');

		var $optimizeSelectedBtn = $(".sgg-optimize-selected");
		if($optimizeSelectedBtn.length > 0) {
			this.$optimizeButton = $optimizeSelectedBtn;
			this.initOptimizeButton(function() {
				// prepare Auth Data
				$optimizeSelectedBtn.attr('data-auth', $('#sgg-ai-optimize-sel-auth').val());

				if($optimizeSelectedBtn.attr('is-for-one-gallery')) {
					$optimizeSelectedBtn.removeAttr('is-for-one-gallery');
				} else {
					// disable button, if anything changed
					var $checkedGalleries = $('.sgg-checkb-inp:checked');
					if($checkedGalleries.length == 0) {
						$optimizeSelectedBtn.prop('disabled', true);
					} else {
						// prepare galleries ids
						var ggIdsInfo = {}
						,	totalSize = 0
						,	photoCount = 0;
						$.each($checkedGalleries, function(index, element) {
							var $element = $(element);
							if($element.val()) {
								ggIdsInfo[$element.val()] = {
									'imglist': null,
									'onceOptimized': $element.attr('data-once-optimize'),
								};
							}
							if(totalSize != '-') {
								if($element.attr('data-gallery-total-size') != '-') {
									totalSize += parseFloat($element.attr('data-gallery-total-size'));
								} else {
									totalSize = '-';
								}
							}
							if($element.attr('data-phot-count')) {
								photoCount += parseFloat($element.attr('data-phot-count'));
							}
						});
						if(totalSize != '-') {
							totalSize = Math.floor(totalSize*100)/100;
						}
						$optimizeSelectedBtn.attr('data-gallery-ids', JSON.stringify(ggIdsInfo));
						$optimizeSelectedBtn.attr('data-gallery-total-size', totalSize);
						$optimizeSelectedBtn.attr('data-gallery-img-cnt', photoCount);
					}
				}
			}, function(galleryIndArray, optParams) {
				if(galleryIndArray && galleryIndArray.length && optParams && optParams.isRestore && optParams.isRestore == '1') {
					for(ind in galleryIndArray) {
						// Restore Button Show
						$('.sgg-restore-src-img[data-gallery-id="' + galleryIndArray[ind] + '"]').removeClass('sgg-io-tab-hidden');
					}
				}
			});
		}

		// initialize "Optimize selected visibility"
		$('.sgg-checkb-inp').on('change', function() {
			setTimeout(function() {
				var $checkedGalleries = $('.sgg-checkb-inp:checked');
				if($checkedGalleries.length > 0) {
					$('.sgg-optimize-selected').prop('disabled', false);
				} else {
					$('.sgg-optimize-selected').prop('disabled', true);
				}
			}, 200);
		});

		$('.sgg-tbl-optimize-retr').on('click', function() {
			var currBtn = $(this)
			,	galleryData = {};
			galleryData[currBtn.attr('data-gallery-id')] = {'imglist': null};
			$optimizeSelectedBtn.attr('is-for-one-gallery', '1');
			$optimizeSelectedBtn.attr('data-gallery-ids', JSON.stringify(galleryData));
			$optimizeSelectedBtn.attr('data-gallery-total-size', currBtn.attr('data-gallery-total-size'));
			$optimizeSelectedBtn.attr('data-gallery-img-cnt', currBtn.attr('data-photo-count'));
			$optimizeSelectedBtn.trigger('click');
		});
		$('.sgg-tbl-optimize-first').on('click', function() {
			var currBtn = $(this)
			,	galleryData = {};
			galleryData[currBtn.attr('data-gallery-id')] = {'imglist': null};
			$optimizeSelectedBtn.attr('is-for-one-gallery', '1');
			$optimizeSelectedBtn.attr('data-gallery-ids', JSON.stringify(galleryData));
			$optimizeSelectedBtn.attr('data-gallery-total-size', currBtn.attr('data-gallery-total-size'));
			$optimizeSelectedBtn.attr('data-gallery-img-cnt', currBtn.attr('data-photo-count'));
			$optimizeSelectedBtn.trigger('click');
		});

		$('.sgg-restore-src-img').on('click', function() {
			var currBtn = $(this);
			currBtn.prop('disabled', true);
			SupsysticGallery.Loader.show('Please wait until all files restored...');
			$.jGrowl('Please wait until all files restored');

			var request = SupsysticGallery.Ajax.Post({
				module: 'optimization',
				action: 'rollbackRestoredImg',
				data: {
					'gallery_id': currBtn.attr('data-gallery-id'),
				},
			});

			request.send(function (response) {
				if (response && response.message) {
					SupsysticGallery.Loader.hide();
				}

			}).fail(function (response) {
				if (response && response.message) {
					$.jGrowl(response.message);
				}
				SupsysticGallery.Loader.hide();
			});
		});

		// change current Main tab
		var sggImgOptMainTabName = $('#sggImgOptMainTabName').val();
		if(sggImgOptMainTabName == 'cdn') {
			$('.sgg-io-tab-link[data-tab-id="sgg-maintab-transfer-cdn"]').trigger('click');
		}
	});

	function sggOptimizeInitDialogWnd($selector, settings) {
		var resultSettings = $.extend({
			'autoOpen': false,
			'modal': true,
			'width': 400,
			'minHeight': 50,
		}, settings);

		$selector.dialog(resultSettings);
	};

	ImageOptimize.prototype.prepareSetupButtons = (function() {

		if(!this.isPrepareSetupButtonsInited) {
			this.isPrepareSetupButtonsInited = true;
			var $serviceSettDialog = $('#sggDialogSeviceSetting');
			sggOptimizeInitDialogWnd($serviceSettDialog, {});

			$('.sgg-service-setting .sgg-setup-button').off('click').on('click', function (event) {
				event.preventDefault();
				var $currButton = $(this);

				// hide all blocks in Dialog
				$('#sggDialogSeviceSetting .sgg-dialog-block-part').addClass('sgg-io-tab-hidden');
				if ($currButton.attr('data-dialog-code')) {
					// display only that block, which is specified in Button attribute
					$serviceSettDialog.find('[data-img-opt-sett-code="' + $currButton.attr('data-dialog-code') + '"]')
					.removeClass('sgg-io-tab-hidden');
					$serviceSettDialog.dialog("option", "title", $currButton.attr('data-dialog-title'));
					$serviceSettDialog.dialog('open');
				}
			});

			var $tinyPngSaveBtn = $('.sgg-tinypng-save');
			$tinyPngSaveBtn.prop("disabled", false);
			$tinyPngSaveBtn.off('click').on('click', function (event) {

				var $inputAuthKey = $(".sgg-tinypng-sett-auth-val")
					, authKey = $inputAuthKey.val().trim();
				if (authKey != '') {
					$tinyPngSaveBtn.prop("disabled", true);
					var request = SupsysticGallery.Ajax.Post({
						module: 'optimization',
						action: 'saveSettings',
						data: {
							'setting_type': 'tinypng',
							'params': {
								'auth_key': authKey
							},
						},
					});

					request.send(function (response) {
						if (response && response.message) {
							$.jGrowl(response.message);
							if (response.success == true) {
								setTimeout(function () {
									location.reload();
									$serviceSettDialog.dialog('close');
									$tinyPngSaveBtn.prop("disabled", false);
								}, 1000);
							}
						}
					}).fail(function () {
						$.jGrowl('Error while data saving');
						$tinyPngSaveBtn.prop("disabled", false);
					});
				} else {
					$.jGrowl('Please, enter the data');
				}
			});
		}
	});

	function sggOptimizeInitTabsFor (blockName) {
		var	$tabLinks = $(blockName + ' > .sgg-io-tab-link');

		$tabLinks.off('click').on('click', function(event) {
			// remove class from all link
			$tabLinks.removeClass('sggActive');
			// remove class from all tabs
			$(blockName + ' > .sgg-io-one-tab').addClass('sgg-io-tab-hidden');

			var $currLink = $(this)
			,	toShowTabId = $currLink.attr('data-tab-id');
			if(toShowTabId) {
				$(blockName + ' > .' + toShowTabId).removeClass('sgg-io-tab-hidden');
			}
			$currLink.addClass('sggActive');
			event.preventDefault();
		});
	};

	function CdnTransfer() {
		this.initIoTab();
	}

	CdnTransfer.prototype.prepareSetupButtons = (function() {

		if(!this.isPrepareSetupButtonsInited) {
			this.isPrepareSetupButtonsInited = true;
			var $serviceSettDialog = $('#sggCdnDialogSeviceSett')
			,	$keyCndZoneName = $('.sgg-keycdn-sett-zonename')
			,	$keyCdnBtnSave = $('.sgg-keycdn-save');
			sggOptimizeInitDialogWnd($serviceSettDialog, {
				'width': 350,
			});

			$('.sgg-cnd-service-info .sgg-setup-button').off('click').on('click', function (event) {
				event.preventDefault();
				var $currButton = $(this);
				$keyCndZoneName.trigger('change');

				// hide all blocks in Dialog
				$('.sgg-cnd-service-info .sgg-dialog-block-part').addClass('sgg-io-tab-hidden');
				if ($currButton.attr('data-dialog-code')) {
					// display only that block, which is specified in Button attribute
					$serviceSettDialog.find('[data-img-opt-sett-code="' + $currButton.attr('data-dialog-code') + '"]')
						.removeClass('sgg-io-tab-hidden');
					$serviceSettDialog.dialog("option", "title", $currButton.attr('data-dialog-title'));
					$serviceSettDialog.dialog('open');
				}
			});
			// site Name change for "Keycdn" service
			$keyCndZoneName.on('change paste keyup', function() {
				var rgSiteName = new RegExp('^[^ "/]{5,}$')
				,	keyCdnZoneNameValue = $keyCndZoneName.val().trim()
				,	regexRes = rgSiteName.exec(keyCdnZoneNameValue);
				if(regexRes && regexRes.length) {
					$keyCdnBtnSave.prop('disabled', false);
				} else {
					$keyCdnBtnSave.prop('disabled', true);
				}
			});
			// Save button click for "Keycdn" service
			$keyCdnBtnSave.off('click').on('click', function() {
				$keyCdnBtnSave.prop("disabled", true);
				var zoneName = $keyCndZoneName.val().trim()
				,	userName = $('.sgg-keycdn-sett-uname').val().trim()
				,	userPass = $('.sgg-keycdn-sett-upass').val().trim()
				,	baseFtpPath = $('.sgg-keycdn-sett-base-ftp').val().trim();


				if(zoneName != '') {
					var request = SupsysticGallery.Ajax.Post({
						module: 'optimization',
						action: 'saveCdnSettings',
						data: {
							'setting_type': 'keycdn',
							'params': {
								'zone_name': zoneName,
								'u_name': userName,
								'u_pass': userPass,
								'base_ftp_path': baseFtpPath,
							},
						},
					});

					request.send(function (response) {
						if (response && response.message) {
							$.jGrowl(response.message);
							if (response.success == true) {
								setTimeout(function () {
									var url = window.location.href;
									if (url.indexOf('sggtab=') === -1) {
										if (url.indexOf('?') > -1) {
											url += '&sggtab=cdn'
										}else{
											url += '?sggtab=cdn'
										}
									}
									window.location.href = url;
									$serviceSettDialog.dialog('close');
								}, 500);
							}
						}
					}).fail(function () {
						$.jGrowl('Error while data saving');
						$keyCdnBtnSave.prop("disabled", false);
					});
				}
			});
		}
	});

	CdnTransfer.prototype.initIoTab = (function() {
		this.prepareSetupButtons();

		var $button = new CdnTransferDialogWindow({})
		,	$transferSelectedBtn = $('.sgg-transer-to-cdn');

		// transfer Selected click
		$transferSelectedBtn.off('click').on('click', function(event) {
			var $checkBoxChecked = $('.sgg-check-gallery-inp:checked')
			,	galleryId;

			if($checkBoxChecked.length) {
				// button params Prepare
				$button.galleryIds = {};
				$.each($checkBoxChecked, function(ind1, obj1) {
					var $input = $(obj1)
						,	gallerySize = parseFloat($input.data('gallery-size'));
					galleryId = $input.val();
					$button.galleryIds[galleryId] = {
						'img-cnt': $input.data('gallery-img-cnt'),
						'img-size': isNaN(gallerySize) ? false : gallerySize,
					};
				});
				$button.showStep1();
			}
		});

		$('.sgg-check-gallery-inp').on('change', function() {
			setTimeout(function() {
				var $checkedCb = $('.sgg-check-gallery-inp:checked');
				if($checkedCb.length) {
					$transferSelectedBtn.prop('disabled', false);
				} else {
					$transferSelectedBtn.prop('disabled', true);
				}
			}, 100);
		});

		// transfer one gallery click
		$('.sgg-transfer-to').off('click').on('click', function() {
			var $currBtn = $(this)
			,	gallerySize = parseFloat($currBtn.data('img-size'));

			$button.galleryIds = {};

			$button.galleryIds[$currBtn.data('gallery-id')] = {
				'img-cnt': $currBtn.data('photo-count'),
				'img-size': isNaN(gallerySize) ? false : gallerySize,
			};
			$button.showStep1();
		});
	});

	function CdnTransferDialogWindow(options) {
		this.options = $.extend({
			'dialogSelector': '#transfer-to-cdn-dialog',
		}, options);

		var selfInit = this;
		this.$dialogWindow = null;
		this.ajaxSendObj = null;
		this.galleryIds = {};
		this.transferParams = {
			'deleteSrc': false,
		};
		this.serviceData = JSON.parse($('#sgg-cdn-auth-sett').val());
		if(this.options) {
			// init dialog
			if(this.options.dialogSelector) {
				this.$dialogWindow = $(this.options.dialogSelector);
				sggOptimizeInitDialogWnd(this.$dialogWindow, {
					'maxHeight': Math.floor($(window).height()*0.9),
					'close' : function() {
						if(selfInit.ajaxSendObj) {
							selfInit.ajaxSendObj.abort();
							selfInit.ajaxSendObj = false;
						}
					},
					'buttons': [
						{
							'text': $("#sgg-transl-start-transf").val(),
							'id': 'sgg-cdndlg-start-transf',
							'click': function() {
								selfInit.step2();
							},
						},
						{
							'text': 'Cancel',
							'id': 'sgg-cnddgl-cancel',
							'click': function () {
								$(this).dialog('close');
							},
						},
						{
							'text': 'Ok',
							'id': 'sgg-cnddgl-ok',
							'click': function () {
								$(this).dialog('close');
							},
						},
					],
				});

				this.$startTransferBtn = $('#sgg-cdndlg-start-transf');
			}

			//init tabs in dialog
			sggOptimizeInitTabsFor('.sgg-il-transfer-dialog');
		}
	}

	CdnTransferDialogWindow.prototype.showStep1 = (function() {

		var keys = Object.keys(this.galleryIds)
		,	isInitError = true
		,	self = this;
		if(this.$dialogWindow && keys.length && this.serviceData && this.serviceData.current
			&& this.serviceData.setting && this.serviceData.setting[this.serviceData.current]) {

			// show button
			this.$startTransferBtn.removeClass('sgg-io-tab-hidden');

			if(this.serviceData.current == 'keycdn') {
				var authObj = this.serviceData.setting[this.serviceData.current];
				// check minimal data
				if(authObj.u_name && authObj.u_pass && authObj.zone_name && authObj.base_ftp_path) {
					self.transferParams.serviceName = this.getSeviceNameByCode(this.serviceData.current);
					self.transferParams.serviceCode = this.serviceData.current;
				}
			}

			if(self.transferParams.serviceName) {
				// service name
				$('.sgg-il-transfer-start .sgg-cdn-service-name').text(self.transferParams.serviceName);
				$('.sgg-il-transfer-process .sgg-cdn-service-name').text(self.transferParams.serviceName);

				var imgCountAmount = 0
				,	imgSizeAmount = 0.0
				,	ind
				,	galleryId;
				// calc Amount of Image count and Image size
				for(ind in keys) {
					galleryId = parseInt(keys[ind], 10);
					if(!isNaN(galleryId)) {
						if(!isNaN(parseFloat(self.galleryIds[galleryId]['img-cnt']))) {
							imgCountAmount += self.galleryIds[galleryId]['img-cnt'];
						}
						if(imgSizeAmount !== false) {
							if(self.galleryIds[galleryId]['img-size'] !== false) {
								if(!isNaN(parseInt(self.galleryIds[galleryId]['img-size'], 10))) {
									imgSizeAmount += self.galleryIds[galleryId]['img-size'];
								}
							} else {
								imgSizeAmount = false;
							}
						}
					}
				}
				$('.sgg-cdndlg-img-count').text(imgCountAmount);
				if(imgSizeAmount === false) {
					$('.sgg-cnddlg-imgs-size-row').addClass('sgg-io-tab-hidden');
					$('.sgg-cnddlg-imgs-size').text('-');
				} else {
					$('.sgg-cnddlg-imgs-size-row').removeClass('sgg-io-tab-hidden');
					$('.sgg-cnddlg-imgs-size').text(imgSizeAmount);
				}

				// open first tab
				$('.sgg-io-tab-link[data-tab-id="sgg-il-transfer-start"]').trigger('click');

				this.$dialogWindow.dialog('option', 'title', 'Image transfer process');
				this.$dialogWindow.dialog('open');
				$('#sgg-cnddgl-cancel').removeClass('sgg-io-tab-hidden');
				$('#sgg-cnddgl-ok').addClass('sgg-io-tab-hidden');
				isInitError = false;
			}
		}

		if(isInitError) {
			$.jGrowl("Error! Initialization Failed!");
		}
	});

	CdnTransferDialogWindow.prototype.step2 = (function() {
		var self = this;
		// get params from 1st window
		this.transferParams.deleteSrc = $('.sgg-cdndlg-delete-res').is('checked') ? 1 : 0;

		// hide elements
		$('.sgg-cdn-info-error').addClass('sgg-io-tab-hidden');
		$('.sgg-cdn-info-succ').addClass('sgg-io-tab-hidden');
		$('.sgg-cdndlg-info').addClass('sgg-io-tab-hidden');
		this.$startTransferBtn.addClass('sgg-io-tab-hidden');

		// loading gallery image list
		var request = SupsysticGallery.Ajax.Post({
			module: 'optimization',
			action: 'getCdnPhotoList',
			data: {
				'optimize-preview': 1,
				'galleries': self.galleryIds,
				'isFilePath': 1,
			},
		});

		$.jGrowl("Prepare information for Gallery transfer...");
		request.send(function (response) {
			if (response && response.success == true && response.photos && response.galleryInfo) {
				self.transferParams.gallerySizeInfo = response.galleryInfo;
				self.step3(response.photos);
			} else {
				$.jGrowl('Error ocurred');
			}
		}).fail(function () {
			$.jGrowl('Error ocurred');
		});

		// open second tab
		$('.sgg-io-tab-link[data-tab-id="sgg-il-transfer-process"]').trigger('click');
	});

	CdnTransferDialogWindow.prototype.step3 = (function(photoList) {

		var keys = Object.keys(this.galleryIds)
		,	self = this
		,	currGall = 0
		,	countGall = keys.length
		,	currPhoto = 0
		,	serviceError = false
		,	hasError = false
		,	ajaxPromise = new $.Deferred().resolve()
		,	oneRequest
		,	photoLogList = []
		,	currLogInd = 0
		,	countPhoto = 0;

		// prepare Log List
		for(var key in keys) {
			currPhoto = 0;
			if(photoList[keys[key]] && photoList[keys[key]].length > 0) {
				countPhoto = photoList[keys[key]].length;
				while(currPhoto < countPhoto) {
					photoLogList[currLogInd] = {
						'gInd': parseInt(key),
						'gId': keys[key],
						'gCount': keys.length,
						'iInd': currPhoto,
						'iCount': countPhoto,
						'photoObj': photoList[keys[key]][currPhoto],
					};
					currLogInd++;
					currPhoto++;
				}
			}
			currGall++;
		};
		self.setTransferInfo(0, countGall, 0, photoList[keys[0]].length);

		function processOneTransferImage(currIndex, logCdnObject) {
			oneRequest = SupsysticGallery.Ajax.Post({
				module: 'optimization',
				action: 'transferOneImage',
				data: {
					'auth_data': self.serviceData,
					'isDelete': self.transferParams.deleteSrc,
					'photoObj': logCdnObject.photoObj,
				},
			});

			this.ajaxSendObj = oneRequest.send(function(opResponse) {
				self.setTransferInfo(logCdnObject.gInd + 1, logCdnObject.gCount, logCdnObject.iInd+1, logCdnObject.iCount);
				if(opResponse) {
					if(!opResponse.success) {
						$.jGrowl(opResponse.message ? opResponse.message: "Unknown Error!");
						hasError = true;
					}
				}
				if(currIndex == currLogInd-1) {
					self.step4(hasError);
				}
			}).fail(function (opResponse, statusText) {
				if(statusText == 'error') {
					$.jGrowl(opResponse.statusText);
					hasError = true;
				}
				self.setTransferInfo(logCdnObject.gInd + 1, logCdnObject.gCount, logCdnObject.iInd+1, logCdnObject.iCount);
				if(currIndex == currLogInd-1 && statusText != "abort") {
					self.step4(hasError);
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

		if(photoLogList.length) {
			$('.sgg-cdndlg-info').removeClass('sgg-io-tab-hidden');
		} else {
			$('.sgg-cdn-info-error').removeClass('sgg-io-tab-hidden');
		}
	});

	CdnTransferDialogWindow.prototype.step4 = (function(hasError) {
		if(hasError) {
			$('.sgg-cdn-info-error').removeClass('sgg-io-tab-hidden');
		} else {
			$('.sgg-cdn-info-succ').removeClass('sgg-io-tab-hidden');

			var keys = Object.keys(this.transferParams.gallerySizeInfo)
				,	self = this;
			// save results to DB
			if(this.transferParams.gallerySizeInfo && keys.length) {
				var request = SupsysticGallery.Ajax.Post({
					module: 'optimization',
					action: 'saveCdnInfoToDb',
					data: {
						'gallery-obj': this.transferParams.gallerySizeInfo,
						'serviceCode': this.transferParams.serviceCode,
					},
				});
				// nothing to show
				request.send(function (response) {
					if(response.galleries && response.galleries.length) {
						// update values in html-table
						for(var ggKey in response.galleries) {

							var ggCdnInfo = response.galleries[ggKey];
							if(ggCdnInfo.gallery_id && ggCdnInfo.last_transfer_date && ggCdnInfo.service_code && ggCdnInfo.size) {

								var galleryId = !isNaN(parseInt(ggCdnInfo.gallery_id, 10)) ? parseInt(ggCdnInfo.gallery_id, 10) : null
									,	showedSize = Math.floor(ggCdnInfo.size*100/1024/1024)/100
									,	serviceInfo = self.getSeviceNameByCode(self.transferParams.serviceCode) + ' / ' + ggCdnInfo.last_transfer_date;

								// set values to table
								$('.sgg-cdn-info-row-' + galleryId + ' .sgg-cdn-info-size').text(showedSize + ' Mb');
								$('.sgg-cdn-info-row-' + galleryId + ' .sgg-cdn-info-tr-date').text(serviceInfo);
							}
						}
					}
				});
			}
			$('#sgg-cnddgl-cancel').addClass('sgg-io-tab-hidden');
			$('#sgg-cnddgl-ok').removeClass('sgg-io-tab-hidden');
		}
	});

	CdnTransferDialogWindow.prototype.setTransferInfo = (function(galleryInd, galleryCount, imageInd, imageCount) {
		$('#sgg-cdn-curr-gallery').text(galleryInd);
		$('#sgg-cdn-gallery-count').text(galleryCount);
		$('#sgg-cdn-curr-img').text(imageInd);
		$('#sgg-cdn-img-count').text(imageCount);
	});

	CdnTransferDialogWindow.prototype.getSeviceNameByCode = (function(code) {
		var serviceName = null;
		if(code == 'keycdn') {
			serviceName = 'KeyCDN';
		}
		return serviceName;
	});

	$(document).ready(function () {
		// init "Image Optimize" scripts
		if($('#sgg-optimize-main-tab-inp').length) {
			var $imageOptimizeModel = new ImageOptimize();
		}
		// init "transfer to CDN" scripts
		if($('#sgg-transfer-to-cdn-used').length) {
			var $cdnModel = new CdnTransfer();
		}

		return true;
	});
} (jQuery, ajaxurl));
