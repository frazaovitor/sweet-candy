<?php

class GridGallery_Ui_Assets
{
	protected $styles = array();
	protected $scripts = array();
	protected $enqueued = array();
	protected $handles = array();

	public function __construct($ui) {
		$this->ui = $ui;
		$this->config = $ui->getConfig();
        $this->prefix = $this->config->get('plugin_name') . '-';
        $this->version = $this->config->get('plugin_version');
        $this->isPluginPage = $ui->isPluginPage();
        add_action('wp_enqueue_scripts', array($this, 'enqueueFrontend'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueBackend'));
	}

	public function register($type, $assets) {
		$this->{'add' . ucfirst($type)}($assets);
	}

	public function enqueue($type, $assets, $location = 'backend', $global = false) {
		if (!$global && !$this->isPluginPage && $location == 'backend') {
			return;
		}
		foreach ($assets as $asset) {
			$this->enqueued[$location][$type][] = $this->prepare($asset);
		}
	}

	private function addStyles($assets) {
		foreach ($assets as $asset) {
			$this->styles[] = $this->prepare($asset);
		}
	}

	private function addScripts($assets) {
		foreach ($assets as $asset) {
			$this->scripts[] = $this->prepare($asset);
		}
	}

	private function prepare($asset) {
		$dependencies = array();
		$version = $this->version;

		if (is_array($asset)) {

			if (!isset($asset['source'])) {
				return;
			}

			$source = $asset['source'];

			if (isset($asset['handle'])) {
				$handle = $asset['handle'];
			} else {
				$handle = basename($asset['source']);
			}

			if (isset($asset['dependencies'])) {
				$dependencies = $asset['dependencies'];
			}

			if (isset($asset['version'])) {
				$version = $asset['version'];
			}

		} elseif (is_string($asset)) {
			$source = $asset;
			$handle = basename($source);
			if ($source == $handle) {
				return array(
					'handle' => $handle,
				);
			}
		}

		if (in_array($handle, $this->handles)) {
			// throw new Exception(sprintf('Handle with name %s already registered', $handle));
		}

		$this->handles[] = $handle;

		return array(
			'handle' => $handle,
			'source' => $source,
			'dependencies' => $dependencies,
			'version' => $version
		);
	}

	public function enqueueFrontend() {
		$this->registerAssets();
		$this->enqueueAssets('frontend');
	}

	public function enqueueBackend() {
		$this->registerAssets();
		$this->enqueueAssets('backend');
	}

	private function enqueueAssets($location) {
		if (isset($this->enqueued[$location])) {
			if (isset($this->enqueued[$location]['styles'])) {
				$this->enqueueStyles($this->enqueued[$location]['styles']);
			}
			if (isset($this->enqueued[$location]['scripts'])) {
				$this->enqueueScripts($this->enqueued[$location]['scripts']);
			}
		}
	}

	private function registerAssets() {
		foreach ($this->styles as $style) {
			extract($style);
			wp_register_style($handle, $source, $dependencies, $version);
		}
		foreach ($this->scripts as $script) {
			extract($script);
			wp_register_script($handle, $source, $dependencies, $version, true);
		}
	}

	private function enqueueStyles($styles) {
		foreach ($styles as $style) {
			extract($style);
			if (!isset($style['source'])) {
				wp_enqueue_style($handle);
				continue;
			}
			wp_enqueue_style($handle, $source, $dependencies, $version);
		}
	}

	private function enqueueScripts($scripts) {
		foreach ($scripts as $script) {
			extract($script);
			if (!isset($script['source'])) {
				wp_enqueue_script($handle);
				continue;
			}
			wp_enqueue_script($handle, $source, $dependencies, $version, true);
		}
	}
}

?>
