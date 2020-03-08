<?php

/**
 * Class GridGallery_Core_Module
 * Core module
 *
 * @package GridGallery\Core
 * @author Artur Kovalevsky
 */
class GridGallery_Core_Module extends Rsc_Mvc_Module
{
    /**
     * {@inheritdoc}
     */
    public function onInit()
    {
        parent::onInit();
        $path = dirname(dirname(dirname(dirname(__FILE__))));
        $url = plugins_url(basename($path));
        $config = $this->getEnvironment()->getConfig();

        //Clear plugin cache after update
        $optionName = $config->get('hooks_prefix') . 'plugin_version';
        $currentVersion = $config->get('plugin_version');
        $oldVersion = get_option($optionName);

        if (version_compare($oldVersion, $currentVersion) === -1) {
            $this->cleanGalleryCache();
            update_option($optionName, $currentVersion);
        }

        $config->add('plugin_url', $url);
        $config->add('plugin_path', $path);

        add_filter('gg_hooks_prefix', array($this, 'addHooksPrefix'), 10, 1);
		add_action('init', array($this, 'registerTwigFunctions'), 10, 1);
    }
    /**
     * Adds the plugin's hooks prefix to the hook name
     *
     * @param string $hook The name of the hook
     * @return string
     */
    public function addHooksPrefix($hook)
    {
        $config = $this->getEnvironment()->getConfig();

        return $config->get('hooks_prefix') . $hook;
    }

    public function afterUiLoaded(Callable $callback)
    {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException('$callback must be a callable');
        }

        add_action($this->addHooksPrefix('after_ui_loaded'), $callback);
    }

    public function getProUrl($params = null) {
        $config = $this->getConfig();
        return $config->get('page_url') . (strpos($params, '?') === 0 ? '' : '?') . $params;
    }

    public function buildProUrl(array $parameters = array())
    {
        $config = $this->getEnvironment()->getConfig();
        $homepage = 'https://supsystic.com/plugins/photo-gallery/';
        $campaign = 'gallery';

        if (!array_key_exists('utm_source', $parameters)) {
            $parameters['utm_source'] = 'plugin';
        }

        if (!array_key_exists('utm_campaign', $parameters)) {
            $parameters['utm_campaign'] = $campaign;
        }

        return $homepage . '?' . http_build_query($parameters);
    }

	public function getPluginDirectoryUrl($path)
	{
		return plugin_dir_url($this->getEnvironment()->getPluginPath() . '/index.php') . '/' . $path;
	}
    public function getCdnUrl() {
        return (is_ssl() ? 'https' : 'http').'://supsystic-42d7.kxcdn.com/';
    }

    public function registerTwigFunctions()
    {

        $twig = $this->getTwig();

		$twig->addFunction(
			new Twig_SimpleFunction(
				'plugin_directory_url', array($this, 'getPluginDirectoryUrl')
			)
		);

        $twig->addFunction(
            new Twig_SimpleFunction(
                'build_pro_url', array($this, 'buildProUrl')
            )
        );

        $twig->addFunction(
            new Twig_SimpleFunction(
                'translate', array($this, 'translate')
            )
        );

        $twig->addFunction(
            new Twig_SimpleFunction(
                'getProUrl', array($this, 'getProUrl')
            )
        );

        $twig->addGlobal('_wpnonce', wp_create_nonce('supsystic-gallery'));
        
        $twig->addFunction(
            new Twig_SimpleFunction(
                'getProUrl', array($this, 'getProUrl')
            )
        );

    }

    //Clear gallery cache after update
    private function cleanGalleryCache() {
        $cachePath = $this->getConfig()->get('plugin_cache_tables');
        if ($cachePath) {
            array_map('unlink', glob("$cachePath/*"));
        }
    }
}

"Fatal error: Uncaught exception 'BadMethodCallException' with message 'Unexpected method: registerTwigFunctions' in E:\OpenServer\domains\mywp\wp-content\plugins\data-tables-generator-by-supsystic\vendor\Rsc\Mvc\Module.php:61 Stack trace: ";
#0 [internal function]: Rsc_Mvc_Module->__call('registerTwigFun...', Array)
#1 [internal function]: GridGallery_Colorbox_Module->registerTwigFunctions('')
#2 E:\OpenServer\domains\mywp\wp-includes\plugin.php(524): call_user_func_array(Array, Array)
#3 E:\OpenServer\domains\mywp\wp-settings.php(411): do_action('init')
#4 E:\OpenServer\domains\mywp\wp-config.php(89): require_once('E:\\OpenServer\\d...')
#5 E:\OpenServer\domains\mywp\wp-load.php(39): require_once('E:\\OpenServer\\d...')
#6 E:\OpenServer\domains\mywp\wp-admin\admin.php(31): require_once('E:\\OpenServer\\d...')
#7 E:\OpenServer\domains\mywp\wp-admin\plugins.php(10): require_once('E:\\OpenServer\\d...')
#8 {main} thrown in E:\OpenServer\domains\mywp\wp-content\plugins\data-tables-generator-by-supsystic\vendor\Rsc\Mvc\Module.php on line 61
