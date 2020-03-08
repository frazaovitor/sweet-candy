jQuery(document).ready(function(){
	var app = window.SupsysticGallery;
	var g_sggAnimationSpeed = 300;
	var $deactivateLnk = jQuery('#the-list tr[data-plugin="'+ sggPluginsData.plugSlug+ '/index.php"] .row-actions .deactivate a');
	if($deactivateLnk && $deactivateLnk.size()) {
		var $deactivateForm = jQuery('#sggDeactivateForm');
		var $deactivateWnd = jQuery('#sggDeactivateWnd').dialog({
			modal:    true
		,	autoOpen: false
		,	width: 500
		,	height: 390
		,	buttons:  {
				'Submit & Deactivate': function() {
					$deactivateForm.submit();
				}
			}
		});
		var $wndButtonset = $deactivateWnd.parents('.ui-dialog:first')
			.find('.ui-dialog-buttonpane .ui-dialog-buttonset')
		,	$deactivateDlgBtn = $deactivateWnd.find('.sggDeactivateSkipDataBtn')
		,	deactivateUrl = $deactivateLnk.attr('href');
		$deactivateDlgBtn.attr('href', deactivateUrl);
		$wndButtonset.append( $deactivateDlgBtn );
		$deactivateLnk.click(function(){
			$deactivateWnd.dialog('open');
			return false;
		});
		
		$deactivateForm.submit(function(){
			var request = app.Ajax.Post({
				module: 'promo'
			,	action: 'saveDeactivateData'
			},	{
				'deactivate_reason': $deactivateForm.find('input[name="deactivate_reason"]:checked').val()
			,	'better_plugin': $deactivateForm.find('input[name="better_plugin"]').val()
			,	'other': $deactivateForm.find('input[name="other"]').val()
			});
			$deactivateForm.find('button').attr('disabled', 'disabled');
			request.send(jQuery.proxy(function (response) {
				window.location.href = deactivateUrl;
			}, this));
			return false;
		});
		$deactivateForm.find('[name="deactivate_reason"]').change(function(){
			jQuery('.sggDeactivateDescShell').slideUp( g_sggAnimationSpeed );
			if(jQuery(this).prop('checked')) {
				var $descShell = jQuery(this).parents('.sggDeactivateReasonShell:first').find('.sggDeactivateDescShell');
				if($descShell && $descShell.size()) {
					$descShell.slideDown( g_sggAnimationSpeed );
				}
			}
		});
	}
});