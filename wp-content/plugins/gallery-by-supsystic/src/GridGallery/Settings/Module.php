<?php

/**
 * Class GridGallery_Settings_Module
 * User settings module
 *
 * @package GridGallery\Settings
 * @author Artur Kovalevsky
 */
class GridGallery_Settings_Module extends Rsc_Mvc_Module
{

    /**
     * @var GridGallery_Settings_Registry
     */
    private $registry;

    /**
     * Returns the Settings Registry
     *
     * @param GridGallery_Settings_SettingsStorageInterface $storage
     * @return GridGallery_Settings_Registry
     */
    public function getRegistry(GridGallery_Settings_SettingsStorageInterface $storage = null)
    {
        if ($this->registry === null) {
            $this->registry = new GridGallery_Settings_Registry(
                $this->getEnvironment()->getConfig()->get('hooks_prefix'),
                $storage
            );
        }

        return $this->registry;
    }

    /**
     * {@inheritdoc}
     */
    public function onInit()
    {
        $this->registerMenu();
        add_action($this->getConfig()->get('hooks_prefix') . 'after_ui_loaded',
            array($this, 'afterUiLoaded_')
        );
    }

    // public function onInstall()
    // {
    //     parent::onInstall();

    //     $registry = $this->getRegistry();
    //     //Set this option to 1 to enable sending statistic
    //     $registry->set('send_stats', 0);
    // }

    public function getBackendCSS() {
        return array(
            '//cdn.jsdelivr.net/chosen/1.1.0/chosen.min.css',
            $this->getLocationUrl() . '/assets/css/settings.css'
        );
    }

    public function getBackendJS() {
        return array(
            '//cdn.jsdelivr.net/chosen/1.1.0/chosen.jquery.min.js',
            array(
                'source' => $this->getLocationUrl() . '/assets/js/settings.index.js',
                'dependencies' => array('chosen.jquery.min.js')
            )
        );
    }

    /**
     * Loads the assets required by the module
     */
    public function afterUiLoaded_(GridGallery_Ui_Module $ui)
    {
        $ui->asset->register('styles', $this->getBackendCSS());
        $ui->asset->register('scripts', $this->getBackendJS());
    }

    public function getTemplatesAliases()
    {
        return array(
            'settings.index' => '@settings/index.twig'
        );
    }

    public function loadAssets()
    {
        $prefix = $this->getConfig()->get('plugin_name') . '-';

        foreach ($this->getBackendCSS() as $source) {
            $handle = basename($source);
            wp_enqueue_style($handle);
        }

        foreach ($this->getBackendJS() as $source) {
            if (is_array($source)) {
                if (isset($source['handle'])) {
                    $handle = $source['handle'];
                } else {
                    $handle = basename($source['source']);
                }
            } else {
                $handle = basename($source);
            }
            wp_enqueue_script($handle);
        }
    }

    public function registerMenu() {

        $menu = $this->getMenu();
        $plugin_menu = $this->getConfig()->get('plugin_menu');
        $capability = $plugin_menu['capability'];

        $submenu = $menu->createSubmenuItem();
        $submenu->setCapability($capability)
            ->setMenuSlug('supsystic-gallery&module=settings')
            ->setMenuTitle($this->translate('Settings'))
            ->setPageTitle($this->translate('Settings'))
            ->setModuleName('settings');
		// Avoid conflicts with old vendor version
		if(method_exists($submenu, 'setSortOrder')) {
			$submenu->setSortOrder(40);
		}

        $menu->addSubmenuItem('settings', $submenu);
    }
}
