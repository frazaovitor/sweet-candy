<?php
class GridGallery_Optimization_Module extends GridGallery_Core_Module{
	public function onInit() {
		parent::onInit();
		$this->registerMenu();

		$config = $this->getEnvironment()->getConfig();
		$prefix = $config->get('hooks_prefix');
		add_action($prefix . 'after_ui_loaded', array($this, 'registerAssets'));
	}

	public function registerAssets(GridGallery_Ui_Module $ui) {
		if($this->getEnvironment()->isModule('optimization')) {
			$ui->asset->enqueue('styles', $this->getBackendCSS());
			$ui->asset->enqueue('scripts', $this->getBackendJS());
		}
	}

	public function getBackendCSS() {
		return array(
			$this->getLocationUrl() . '/assets/css/backend.index.css',
		);
	}

	public function getBackendJS() {
		return array(
			$this->getLocationUrl() . '/assets/js/backend.index.js',
		);
	}

	public function registerMenu() {

		$menu = $this->getMenu();
		$plugin_menu = $this->getConfig()->get('plugin_menu');
		$capability = $plugin_menu['capability'];

		$submenu = $menu->createSubmenuItem();
		$submenu->setCapability($capability)
			->setMenuSlug('supsystic-gallery&module=optimization')
			->setMenuTitle($this->translate(translate('Image Optimize')))
			->setPageTitle($this->translate(translate('Optimization')))
			->setModuleName('optimization');
		// Avoid conflicts with old vendor version
		if(method_exists($submenu, 'setSortOrder')) {
			$submenu->setSortOrder(30);
		}

		$menu->addSubmenuItem('optimization', $submenu);
	}
}