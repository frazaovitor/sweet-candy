(function($) {
	var btnCreateObj = {
			container: 'body',
			dialogClass: '.gallery-select-dialog',
			dataList: null,
			initDialog: function() {
				$(this.container).append(
					'<div class="gallery-select-dialog" hidden>' +
					'<h1 style="text-align: center;">Select Gallery</h1>' +
					'<select></select>' +
					'<button class="button button-primary">Insert</button>' +
					'</div>');
				btnCreateObj.setSelectboxOpts();
			},
			setSelectboxOpts: function() {
				var self = this,
					$container = $(self.container),
					select = $container.find(self.dialogClass + ' select');

				if(self.dataList === null) {
					self.setDataList();
				} else if(self.dataList.length) {
					$.each(self.dataList, function(index, value) {
						select.append('<option value="' + value.id + '">' + value.title + '</option>');
					});
				} else {
					select.append('<option value="0">No galleries for now...</option>');
					select.attr('disabled', 'disabled');
				}
			},
			setDataList: function() {
				var self = this,
					url = wp.ajax.settings.url;

				$.post(url, {
						action: 'grid-gallery',
						_wpnonce: SupsysticGallery.nonce,
						route:  {
							module: 'galleries',
							action: 'list'
						}
					}, function(response) {
						self.dataList = [];

						if(response.galleries.length) {
							$.each(response.galleries, function(index, value) {
								self.dataList.push({id: value.id, title: value.title});
							});
						}
						self.setSelectboxOpts();
					}
				);
			}
		},
		dialogIsInit = false;

	tinymce.create('tinymce.plugins.addShortcode', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			ed.addButton('addShortcode', {
				title : 'Add Gallery',
				cmd : 'addShortcode',
				image : url + '/img/logo_gallery.png'
			});
			ed.addCommand('addShortcode', function() {
				if (!dialogIsInit) {
					btnCreateObj.initDialog();
					dialogIsInit = true;
				}
				var $dialog = $(btnCreateObj.dialogClass).bPopup({
					onClose: function() {
						$(btnCreateObj.dialogClass + ' button').off('click');
					}
				}, function() {
					$(btnCreateObj.dialogClass + ' button').on('click', function() {
						var selected = $(btnCreateObj.dialogClass).find('select').val();
						ed.execCommand('mceInsertContent', 0, '[supsystic-gallery id=' + selected + ' position=center]');
						$dialog.close();
					});
				});
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Gallery by Supsystic buttons',
				author : 'Dmitriy Smus',
				infourl : 'http://supsystic.com',
				version : "0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add( 'addShortcode', tinymce.plugins.addShortcode );

})(jQuery);