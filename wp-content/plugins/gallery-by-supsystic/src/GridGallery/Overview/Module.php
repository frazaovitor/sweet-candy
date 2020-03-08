<?php


class GridGallery_Overview_Module extends Rsc_Mvc_Module
{

    /**
     * {@inheritdoc}
     */
    public function onInit()
    {
        $environment = $this->getEnvironment();
        $config = $environment->getConfig();

        $this->registerMenu();

        // Client ID
        $config->add('post_id', 637);
        $config->add('post_url', 'http://supsystic.com/news/main.html');
        $config->add('mail', 'support@supsystic.zendesk.com');

        $prefix = $config->get('hooks_prefix');

        add_action($prefix . 'after_ui_loaded', array(
            $this, 'loadAssets'
        ));
    }

    /**
     * Loads the assets required by the module
     */
    public function loadAssets(GridGallery_Ui_Module $ui)
    {
        if($this->getEnvironment()->isModule('overview')) {
            $ui->asset->enqueue('styles',
                array(
                    $this->getLocationUrl() . '/assets/css/overview-styles.css'
                )
            );
            $ui->asset->enqueue('scripts',
                array(
                    $this->getLocationUrl() . '/assets/js/overview-settings.js'
                )
            );
        }
    }

    public function registerMenu()
    {
        $menu = $this->getMenu();
        $plugin_menu = $this->getConfig()->get('plugin_menu');
        $capability = $plugin_menu['capability'];
        $submenu = $menu->createSubmenuItem();

        $submenu->setCapability($capability)
            ->setMenuSlug('supsystic-gallery&module=overview')
            ->setMenuTitle($this->translate('Overview'))
            ->setPageTitle($this->translate('Overview'))
            ->setModuleName('overview');
		// Avoid conflicts with old vendor version
		if(method_exists($submenu, 'setSortOrder')) {
			$submenu->setSortOrder(10);
		}

        $menu->addSubmenuItem('ovewrview', $submenu);
    }
} 