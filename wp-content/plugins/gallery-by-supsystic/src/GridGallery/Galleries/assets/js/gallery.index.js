(function ($) {
	$(document).ready(function () {
		var $tables = $('#galleries'),
			tableList = $tables.DataTable({
				info: true,
				scrollX: false,
				pagingType: 'full_numbers',
				language: {
					search: '',
					searchPlaceholder: 'Search',
					lengthMenu: '<select>'+
					'<option value="10">10</option>'+
					'<option value="50">50</option>'+
					'<option value="200">200</option>'+
					'<option value="1000">1000</option>'+
					'</select>'
				},
				dom: '<"top"f><"dt_rigth"il><"dt_left"p>rt',
				columnDefs: [
					{ "orderable": false, "targets": [0, 3, 4, 5, 6] },
					{ "className": "dt-center", "targets": [0, 1, 2, 3, 4, 5] }
				],
				order: [[1, 'asc']],
				fnInitComplete: function () {
					setCustomStyle();
					setCheckboxesClick();
				},
				fnDrawCallback: function(oSettings) {
					if (oSettings._iDisplayLength >= oSettings.fnRecordsDisplay()) {
						$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
					}
				}
			});

		tableList.on('draw', function () {
			setCustomStyle();
			controlCheckboxes($('.icheckbox_minimal'), false);
			setCheckboxesClick();
			setGroupBtn();
		});
		tableList.on('search', function () {
			setCustomStyle();
		});

		function setCustomStyle() {
			var info = $('.dataTables_info');

			info.text(info.text().replace('Showing', 'View').replace('to', '-').replace(' entries', ' '));
			$('.paginate_button').removeClass('paginate_button').addClass('paginate_links');
			$('#galleries_first').empty().append($('<i>').addClass('fa fa-angle-double-left'));
			$('#galleries_last').empty().append($('<i>').addClass('fa fa-angle-double-right'));
			$('#galleries_previous').empty().append($('<i>').addClass('fa fa-angle-left'));
			$('#galleries_next').empty().append($('<i>').addClass('fa fa-angle-right'));
		}
		function setGroupBtn() {
			var checked = $('.icheckbox_minimal').filter('.checked');

			if (checked && checked.length > 0) {
				$('#delete-group').removeAttr('disabled');
			} else {
				$('#delete-group').attr('disabled', 'disabled');
			}
		}

		function setCheckboxesClick() {
			$('.iCheck-helper').off('click.group').on('click.group', function() {
				var icheckbox = $(this).closest('.icheckbox_minimal'),
					checked = icheckbox.attr('class').indexOf('checked') >= 0,
					id = icheckbox.find('input').attr('id')

				if (id == 'check_all') {
					controlCheckboxes($('.icheckbox_minimal'), checked);
				} else if(!checked) {
					controlCheckboxes($('.icheckbox_minimal').has('#check_all'), false);
				}
				setGroupBtn();
			});
		}
		function controlCheckboxes(obj, check) {
			if(check) {
				obj.addClass('checked').find('input').attr('checked','checked');
			} else {
				obj.removeClass('checked').find('input').removeAttr('checked');
			}
		}

		$('#delete-group').on('click', function() {
			if (!confirm('Are you sure?')) {
				return;
			}
			var checks = $('#galleries_wrapper .icheckbox_minimal:not(:has(#check_all))').filter('.checked'),
				ids = [];

			for (var i = 0; i < checks.length; i++) {
				ids.push(parseInt(checks.eq(i).find('input').data('gallery-id')));
			}

			$.post(window.wp.ajax.settings.url,
				{
					action: 'grid-gallery',
					_wpnonce: SupsysticGallery.nonce,
					route: {
						module: 'galleries',
						action: 'deleteGroup'
					},
					gallery_ids : ids

				}).done(function () {
				for (i = 0; i < checks.length; i++) {
					checks.eq(i).parents('tr').fadeOut(function () {
						$(this).remove();
						if ($tables.find('tr').length < 4) {
							$tables.find('tr.empty').fadeIn();
						}
					});
				}
				}).fail(function (error) {
					alert(error);
				});
			return false;
		});

		$('.shortcode').on('click', function () { $(this).select() });

	});
}(window.jQuery));
