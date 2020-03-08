<?php

/**
 * Class SocialSharing_Promo_Module
 *
 * Promo module.
 */
class GridGallery_Promo_Module extends GridGallery_Core_Module
{
	/**
	 * Module initialization.
	 */
	public function onInit()
	{
		parent::onInit();
		
		//add_action($this->getConfig()->get('hooks_prefix') . 'after_ui_loaded', array($this, 'loadAdminPromoAssets'));
		add_action('admin_init', array($this, 'loadAdminPromoAssets'));
		add_action('admin_footer', array($this, 'checkPluginDeactivation'));
		add_action('wp_ajax_sgg-tutorial-close', array($this, 'endTutorial'));

		$dispatcher = $this->getEnvironment()->getDispatcher();
		$dispatcher->on('messages', array($this, 'renderDiscountMsg'));
	}
	public function loadAdminPromoAssets() {
		$ui = $this->getEnvironment()->getModule('Ui');

		if (!get_user_meta(get_current_user_id(), 'sgg-tutorial_was_showed', true)) {

			$ui->asset->enqueue('scripts', array(
				array(
					'handle' => 'sgg-step-tutorial',
					'source' => $this->getLocationUrl() . '/assets/js/tutorial.js',
					'dependencies' => array('wp-pointer', 'sg-ajax.js')
				)
			), 'backend', true);

			add_action('admin_enqueue_scripts', array($this, 'enqueueTutorialAssets'));
		}

		if ($this->isModule('promo', 'welcome') && !$this->getConfig()->get('welcome_page_was_showed')) {
			$ui->asset->enqueue('styles', array(
				$this->getConfig()->get('plugin_url') . '/app/assets/css/libraries/bootstrap/bootstrap.min.css'
			));
			update_option($this->getConfig()->get('db_prefix') . 'welcome_page_was_showed', 1);
		}
	}
	// Unused for now
	public function loadAssets(GridGallery_Ui_Module $ui) {

		if (!get_user_meta(get_current_user_id(), 'sgg-tutorial_was_showed', true)) {

			$ui->asset->enqueue('scripts', array(
				array(
					'handle' => 'sgg-step-tutorial',
					'source' => $this->getLocationUrl() . '/assets/js/tutorial.js',
					'dependencies' => array('wp-pointer')
				)
			));

			add_action('admin_enqueue_scripts', array($this, 'enqueueTutorialAssets'));

		}

		if ($this->isModule('promo', 'welcome') && !$this->getConfig()->get('welcome_page_was_showed')) {
			$ui->asset->enqueue('styles', array(
				$this->getConfig()->get('plugin_url') . '/app/assets/css/libraries/bootstrap/bootstrap.min.css'
			));
			update_option($this->getConfig()->get('db_prefix') . 'welcome_page_was_showed', 1);
		}
	}

	public function enqueueTutorialAssets() {

		wp_enqueue_style('wp-pointer');

		$data = array(
			'next'  => $this->translate('Next'),
			'close' => $this->translate('Close Tutorial'),
			'pointersData'	=> $this->pointers(),
		);

		wp_localize_script('sgg-step-tutorial', 'GalleryPromoPointers', $data);
	}

	public function pointers()
	{
		return array(
			array(
				'id' => 'step-0',
				'class' => 'sgg-tutorial-step-0',
				'title'	 => sprintf('<h3>%s</h3>', $this->translate('Welcome to Photo Gallery plugin by Supsystic!')),
				'content'   => sprintf('<p>%s</p>', $this->translate('Thank you for choosing our Gallery plugin. Just click here to start using it - and we will show you it\'s possibilities and powerfull features.')),
				'target' => '#toplevel_page_supsystic-gallery',
				'edge'	  => 'left',
				'align'	 => 'left',
				'nextURL' => $this->getEnvironment()->generateUrl('overview')
			),
			array(
				'id' => 'step-1',
				'class' => 'sgg-tutorial-step-1',
				'title'	 => sprintf('<h3>%s</h3>', $this->translate('Hello! This is the Gallery by Supsystic Overview.')),
				'content'   => sprintf('<p>%s</p>', $this->translate('Here you can get help: watch the video tutorial or read FAQ and Documentation, make use of contact form. Also here requirements for server - Server Settings.')),
				'target' => 'nav.supsystic-navigation li:eq(0)',
				'edge'	  => 'top',
				'align'	 => 'left',
				'nextURL' => $this->getEnvironment()->generateUrl('galleries', 'showPresets')
			),
			array(
				'id' => 'step-2',
				'class' => 'sgg-tutorial-step-2',
				'title'	 => sprintf('<h3>%s</h3>', $this->translate('Create your first Gallery')),
				'content'   => sprintf('<p>%s</p>', $this->translate('To Create New Gallery select gallery template. You can change template and settings later. Now here are four different templates. With PRO version you’ll get more features like Categories, Load More button, Post Feed (Content) gallery, Polaroid gallery and more. Enter name of the gallery and click “Save”.')),
				'target' => '#gallery-create',
				'edge'	  => 'top',
				'align'	 => 'middle',
				'nextURL' => false,
			),
			array(
				'id' => 'step-3',
				'class' => 'sgg-tutorial-step-3',
				'title'	 => sprintf('<h3>%s</h3>', $this->translate('Add images to your Gallery')),
				'content'   => sprintf('<p>%s</p>', $this->translate('Now you are in the edit menu of your gallery. And the first thing you need to do are add media to the gallery. Click "Add Images" button.')),
				'target' => 'button.gallery.import-to-gallery',
				'edge'	  => 'top',
				'align'	 => 'left',
				'nextURL' => false,
			),
			array(
				'id' => 'step-4',
				'class' => 'sgg-tutorial-step-4',
				'title'	 => sprintf('<h3>%s</h3>', $this->translate('Images Import Options')),
				'content'   => sprintf('%s', $this->translate('<p>Import images in several ways:</p><p>Import from Wordpress Media Library/Upload files from your computer</p><p>Import from social networks</p><p>Instagram (in the Free version)</p><p>With PRO-version also will be available import from Flickr, Tumblr and Facebook.</p><p>Besides with Gallery PRO version you can import images from such cloud services - FTP server, Google Drive.</p>')),
				'target' => 'button.gallery#gg-btn-upload',
				'edge'	  => 'left',
				'align'	 => 'top',
				'nextURL' => false,
			),
			array(
				'id' => 'step-5',
				'class' => 'sgg-tutorial-step-5',
				'title'	 => sprintf('<h3>%s</h3>', $this->translate('Image List')),
				'content'   => sprintf('%s', $this->translate('<p>Now you can see your image list. Here you can:</p><p>Change the order of images – simply by dragging them manually.</p><p>Delete images.</p><p>Add new images from different sources to the grid gallery – click “Add Images” button and select the source to import from.</p><p><b>Caption tab</b> – add caption to image – it will be displayed on the caption effect of the gallery. Also here included the support of html-elements inside caption effect</p><p><b>SEO tab</b> – manage image title and description</p><p><b>Link tab</b> – attach links to image – it will go to the link when you click the image.</p><p><b>Video tab</b> – attach video url – it will be displayed in a pop-up image when you click on the image.</p><p><b>Categories tab</b> – add tags for image categories.</p><p><b>Linked images tab</b> – add linked images to the chosen image.</p><p><b>Crop tab</b> – choose image crop position.</p><p><b>Replace image tab</b> – replace image without losing image settings.</p><p>Now follow to the gallery settings – сlick “Properties” button.</p>')),
				'target' => '#supsystic-breadcrumbs',
				'edge'	  => 'top',
				'align'	 => 'right',
				'nextURL' => false,
			),
			array(
				'id' => 'step-6',
				'class' => 'sgg-tutorial-step-6',
				'title'	 => sprintf('<h3>%s</h3>', $this->translate('Preview of Gallery settings')),
				'content'   => sprintf('<p>%s</p>', $this->translate('At the left side of the monitor you see a preview image in which will be seen changes made to the settings. This window for the settings of your gallery.')),
				'target' => '#preview .grid-gallery-caption',
				'edge'	  => 'left',
				'align'	 => 'top',
				'nextURL' => '#',
			),
			array(
				'id' => 'step-7',
				'class' => 'sgg-tutorial-step-7',
				'title'	 => sprintf('<h3>%s</h3>', $this->translate('Main Settings')),
				'content'   => sprintf('%s', $this->translate('<p>Here you can set main settings of gallery - choose Gallery Type, for more information check this <a href="//supsystic.com/gallery-order-types/" target="_blank">article</a>.</p><p>Social Sharing: add social share buttons to your gallery. Or showcase images in a Horizontal Scroll view.</p><p>Load More: adds "load more" button to your gallery. And with Custom Buttons: you can make your button better.</p><p>Add to images border and shadow with Border Type and Shadow settings.</p><p>In the Pop-up Image section customize lightbox of your gallery.</p>')),
				'target' => '.supsystic-plugin .form-tabs a:eq(0)',
				'edge'	  => 'right',
				'align'	 => 'top',
				'nextURL' => '#',
			),
			array(
				'id' => 'step-8',
				'class' => 'sgg-tutorial-step-8',
				'title'	 => sprintf('<h3>%s</h3>', $this->translate('Captions and Icons')),
				'content'   => sprintf('%s', $this->translate('<p>On Captions tab you can manage the Captions and Icons, and make them your style.</p>')),
				'target' => '.supsystic-plugin .form-tabs a:eq(1)',
				'edge'	  => 'right',
				'align'	 => 'top',
				'nextURL' => '#',
			),
			array(
				'id' => 'step-9',
				'class' => 'sgg-tutorial-step-9',
				'title'	 => sprintf('<h3>%s</h3>', $this->translate('Categories and Pagination')),
				'content'   => sprintf('%s', $this->translate('<p>Categories tab: here you can enable Categories and Pagination options.</p><p>To this tab become available you need to buy PRO version.')),
				'target' => '.supsystic-plugin .form-tabs a:eq(2)',
				'edge'	  => 'right',
				'align'	 => 'top',
				'nextURL' => '#',
			),
			array(
				'id' => 'step-10',
				'class' => 'sgg-tutorial-step-10',
				'title'	 => sprintf('<h3>%s</h3>', $this->translate('Posts')),
				'content'   => sprintf('%s', $this->translate('<p>Posts tab: here you can add posts and pages to your gallery and also manage them. Posts of gallery included in the PRO version of Gallery by Supsystic.</p>')),
				'target' => '.supsystic-plugin .form-tabs a:eq(3)',
				'edge'	  => 'right',
				'align'	 => 'top',
				'nextURL' => '#',
			),
			array(
				'id' => 'step-11',
				'class' => 'sgg-tutorial-step-11',
				'title'	 => sprintf('<h3>%s</h3>', $this->translate('Well done!')),
				'content'   => sprintf('%s', $this->translate('<p><b>Upgrading</b></p><p>Once you have purchased Premium version of plugin - you’ll have to enter license key (you can find it in your personal account on our site). Go to the License tab and enter your email and license key. Once you have activated your PRO license - you can use all its advanced options.</p><p>That’s all. From this moment you can use your Gallery without any doubt. But if you still have some question - do not hesitate to contact us through our <a href="https://supsystic.com/contact-us/">internal support</a> or on our <a href="http://supsystic.com/forum/photo-gallery-plugin/">Supsystic Forum.</a> Besides you can always describe your questions on <a href="https://wordpress.org/support/plugin/gallery-by-supsystic">WordPress Ultimate Forum.</a></p><p><b>Enjoy this plugin?</b></p><p>It will be nice if you`ll help us and boost plugin with <a href="https://wordpress.org/support/view/plugin-reviews/gallery-by-supsystic?rate=5#postform/">Five Stars rating on WordPress.org.</a></p><p>We hope that you like this plugin and wish you all the best! Good luck!</p>')),
				'target' => '.supsystic-plugin',
				'edge'	  => 'top',
				'align'	 => 'center',
				'nextURL' => '#',
			)
		);
	}

	public function endTutorial() {
		update_user_meta(get_current_user_id(), 'sgg-tutorial_was_showed', true);
	}
	
	public function checkPluginDeactivation() {
		if(function_exists('get_current_screen')) {
			$screen = get_current_screen();
			if($screen && isset($screen->base) && $screen->base == 'plugins') {
				wp_enqueue_script('jquery-ui-dialog');
				wp_enqueue_script('sgg.admin.plugins', $this->getLocationUrl() . '/assets/js/admin.plugins.js');
				wp_localize_script('sgg.admin.plugins', 'sggPluginsData', array(
					'plugSlug' => $this->getEnvironment()->getConfig()->get('plugin_folder_name')
				));
				$ui = $this->getEnvironment()->getModule('ui');
				$backendCss = $ui->getBackendCSS();
				foreach($backendCss as $s) {
					$src = is_string($s) ? $s : $s['source'];
					wp_enqueue_style(basename($src), $src);
				}
				echo $this->render('@promo/pluginDeactivation.twig');
			}
		}
	}
	public function render($template, $parameters = array())
	{
		$twig = $this->getEnvironment()->getTwig();
        try {
            return preg_replace('/\s+/', ' ', trim($twig->render($template, $parameters)));
        } catch (Exception $e) {
            if (WP_DEBUG) {
                return $e->getMessage();
            }
        }
		return preg_replace('/\s+/', ' ', trim($twig->render($template, $parameters)));
	}
	public function renderDiscountMsg()
	{
		$environment = $this->getEnvironment();
		if($environment->isPro() && $environment->isModule('license') && $environment->getModule('license')->isActive()) {
			$proPluginsList = array(
				'ultimate-maps-by-supsystic-pro', 'newsletters-by-supsystic-pro', 'contact-form-by-supsystic-pro', 'live-chat-pro',
				'digital-publications-supsystic-pro', 'coming-soon-supsystic-pro', 'price-table-supsystic-pro', 'tables-generator-pro',
				'social-share-pro', 'popup-by-supsystic-pro', 'supsystic_slider_pro', 'supsystic-gallery-pro', 'google-maps-easy-pro',
				'backup-supsystic-pro',
			);
			$activePluginsList = get_option('active_plugins', array());
			$activeProPluginsCount = 0;
			foreach($activePluginsList as $actPl) {
				foreach($proPluginsList as $proPl) {
					if(strpos($actPl, $proPl) !== false) {
						$activeProPluginsCount++;
					}
				}
			}
			if($activeProPluginsCount === 1) {
				$twig = $this->getEnvironment()->getTwig();
				$twig->display('@promo/discountMessage.twig', array(
					'bundlePageLink' => '//supsystic.com/all-plugins/',
					'buyLink' => $this->getDiscountBuyUrl(),
				));
			}
		}
	}
	public function getDiscountBuyUrl() {
		$environment = $this->getEnvironment();
		$pluginCode = $environment->getConfig()->get('plugin_product_code');
		$license = $environment->getModule('license')->getHelper()->getCredentials();
		$license['key'] = md5($license['key']);
		$license = urlencode(base64_encode(implode('|', $license)));
		return 'http://supsystic.com/?mod=manager&pl=lms&action=extend&plugin_code='. $pluginCode. '&lic='. $license;
	}
}