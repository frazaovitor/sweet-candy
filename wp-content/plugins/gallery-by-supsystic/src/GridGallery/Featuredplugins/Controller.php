<?php

/**
 * Class GridGallery_Featuredplugins_Controller
 * Featuredplugins page controller
 *
 * @package GridGallery\Featuredplugins
 */
class GridGallery_Featuredplugins_Controller extends GridGallery_Core_BaseController
{
    /**
     * @param Rsc_Http_Request $request
     */
    public function indexAction(Rsc_Http_Request $request)
    {
		//framePps::_()->getModule('templates')->loadBootstrapSimple();
		//framePps::_()->addStyle('admin.featured-plugins', $this->getModule()->getModPath(). 'css/admin.featured-plugins.css');
		//framePps::_()->getModule('templates')->loadGoogleFont('Montserrat');
		$environment = $this->getEnvironment();

		
		$siteUrl = 'https://supsystic.com/';
		$pluginsUrl = $siteUrl. 'plugins/';
		$uploadsUrl = $siteUrl. 'wp-content/uploads/';
		$downloadsUrl = 'https://downloads.wordpress.org/plugin/';
		$promoCampaign = 'gallery';
		$pluginsList = array(
			array('label' => $environment->translate('Popup Plugin'), 'url' => $pluginsUrl. 'popup-plugin/', 'img' => $uploadsUrl. '2016/07/Popup_256.png', 'desc' => $environment->translate('The Best WordPress PopUp option plugin to help you gain more subscribers, social followers or advertisement. Responsive pop-ups with friendly options.'), 'download' => $downloadsUrl. 'popup-by-supsystic.zip'),
			array('label' => $environment->translate('Slider Plugin'), 'url' => $pluginsUrl. 'slider/', 'img' => $uploadsUrl. '2016/07/Slider_256.png', 'desc' => $environment->translate('Creating slideshows with Slider plugin is fast and easy. Simply select images from your WordPress Media Library, Flickr, Instagram or Facebook, set slide captions, links and SEO fields all from one page.'), 'download' => $downloadsUrl. 'slider-by-supsystic.zip'),
			array('label' => $environment->translate('Photo Gallery Plugin'), 'url' => $pluginsUrl. 'photo-gallery/', 'img' => $uploadsUrl. '2016/07/Gallery_256.png', 'desc' => $environment->translate('Photo Gallery Plugin with a great number of layouts will help you to create quality respectable portfolios and image galleries.'), 'download' => $downloadsUrl. 'gallery-by-supsystic.zip'),
			array('label' => $environment->translate('Data Tables Generator'), 'url' => $pluginsUrl. 'data-tables-generator-plugin/', 'img' => $uploadsUrl. '2016/07/Data_Tables_256.png', 'desc' => $environment->translate('Create and manage beautiful data tables with custom design. No HTML knowledge is required.'), 'download' => $downloadsUrl. 'data-tables-generator-by-supsystic.zip'),
			array('label' => $environment->translate('Social Share Buttons'), 'url' => $pluginsUrl. 'social-share-plugin/', 'img' => $uploadsUrl. '2016/07/Social_Buttons_256.png', 'desc' => $environment->translate('Social share buttons to increase social traffic and popularity. Social sharing to Facebook, Twitter and other social networks.'), 'download' => $downloadsUrl. 'social-share-buttons-by-supsystic.zip'),
			array('label' => $environment->translate('Live Chat Plugin'), 'url' => $pluginsUrl. 'live-chat/', 'img' => $uploadsUrl. '2016/07/Live_Chat_256.png', 'desc' => $environment->translate('Be closer to your visitors and customers with Live Chat Support by Supsystic. Help you visitors, support them in real-time with exceptional Live Chat WordPress plugin by Supsystic.'), 'download' => $downloadsUrl. 'live-chat-by-supsystic.zip'),
			array('label' => $environment->translate('Pricing Table'), 'url' => $pluginsUrl. 'pricing-table/', 'img' => $uploadsUrl. '2016/07/Pricing_Table_256.png', 'desc' => $environment->translate('It’s never been so easy to create and manage pricing and comparison tables with table builder. Any element of the table can be customise with mouse click.'), 'download' => $downloadsUrl. 'pricing-table-by-supsystic.zip'),
			array('label' => $environment->translate('Coming Soon Plugin'), 'url' => $pluginsUrl. 'coming-soon-plugin/', 'img' => $uploadsUrl. '2016/07/Coming_Soon_256.png', 'desc' => $environment->translate('Coming soon page with drag-and-drop builder or under construction | maintenance mode to notify visitors and collects emails.'), 'download' => $downloadsUrl. 'coming-soon-by-supsystic.zip'),
			array('label' => $environment->translate('Backup Plugin'), 'url' => $pluginsUrl. 'backup-plugin/', 'img' => $uploadsUrl. '2016/07/Backup_256.png', 'desc' => $environment->translate('Backup and Restore WordPress Plugin by Supsystic provides quick and unhitched DropBox, FTP, Amazon S3, Google Drive backup for your WordPress website.'), 'download' => $downloadsUrl. 'backup-by-supsystic.zip'),
			array('label' => $environment->translate('Google Maps Easy'), 'url' => $pluginsUrl. 'google-maps-plugin/', 'img' => $uploadsUrl. '2016/07/Google_Maps_256.png', 'desc' => $environment->translate('Display custom Google Maps. Set markers and locations with text, images, categories and links. Customize google map in a simple and intuitive way.'), 'download' => $downloadsUrl. 'google-maps-easy.zip'),
			array('label' => $environment->translate('Digital Publication Plugin'), 'url' => $pluginsUrl. 'digital-publication-plugin/', 'img' => $uploadsUrl. '2016/07/Digital_Publication_256.png', 'desc' => $environment->translate('Digital Publication WordPress Plugin by Supsystic for Magazines, Catalogs, Portfolios. Convert images, posts, PDF to the page flip book.'), 'download' => $downloadsUrl. 'digital-publications-by-supsystic.zip'),
			array('label' => $environment->translate('Contact Form Plugin'), 'url' => $pluginsUrl. 'contact-form-plugin/', 'img' => $uploadsUrl. '2016/07/Contact_Form_256.png', 'desc' => $environment->translate('One of the best plugin for creating Contact Forms on your WordPress site. Changeable fonts, backgrounds, an option for adding fields etc.'), 'download' => $downloadsUrl. 'contact-form-by-supsystic.zip'),
			array('label' => $environment->translate('Newsletter Plugin'), 'url' => $pluginsUrl. 'newsletter-plugin/', 'img' => $uploadsUrl. '2016/08/icon-256x256.png', 'desc' => $environment->translate('Supsystic Newsletter plugin for automatic mailing of your letters. You will have no need to control it or send them manually. No coding, hard skills or long hours of customizing are required.'), 'download' => $downloadsUrl. 'newsletter-by-supsystic.zip'),
			array('label' => $environment->translate('Membership by Supsystic'), 'url' => $pluginsUrl. 'membership-plugin/', 'img' => $uploadsUrl. '2016/09/256.png', 'desc' => $environment->translate('Create online membership community with custom user profiles, roles, FrontEnd registration and login. Members Directory, activity, groups, messages.'), 'download' => $downloadsUrl. 'membership-by-supsystic.zip'),
			array('label' => $environment->translate('Kinsta Hosting'), 'url' => 'https://kinsta.com?kaid=MNRQQASUYJRT', 'external' => true, 'img' => $this->getEnvironment()->getModule('core')->getPluginDirectoryUrl('app/assets/img/kinsta_banner.png'), 'desc' => $environment->translate('If you want to host a business site or a blog, Kinsta managed WordPress hosting is the best place to stop on. Without any hesitation, we can say Kinsta is incredible when it comes to uptime and speed.')),
		);
		foreach($pluginsList as $i => $p) {
			if(empty($p['external'])) {
				$pluginsList[$i]['url'] = $pluginsList[$i]['url'] . '?utm_source=plugin&utm_medium=featured_plugins&utm_campaign=' . $promoCampaign;
			}
		}

        return $this->response(
            '@featuredplugins/index.twig',
            array(
                'pluginsList' => $pluginsList,
                'bundleUrl' => $siteUrl. 'product/plugins-bundle/'. '?utm_source=plugin&utm_medium=featured_plugins&utm_campaign='. $promoCampaign,
            )
        );
    }
} 