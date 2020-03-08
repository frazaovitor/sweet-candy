<?php


class Rsc_Environment
{

    const ENV_DEVELOPMENT = 'development';
    const ENV_PRODUCTION  = 'production';

    /**
     * @var array
     */
    protected $defaults = array(
        'environment' => self::ENV_PRODUCTION,
    );

    protected $isWPInit = false;

    /**
     * @var string
     */
    protected $pluginName;

    /**
     * @var string
     */
    protected $pluginPath;

    /**
     * @var Rsc_Config
     */
    protected $config;

    /**
     * @var Rsc_Cache
     */
    protected $cache;

    /**
     * @var Rsc_ClassLoader
     */
    protected $loader;

    /**
     * @var Rsc_Lang
     */
    protected $lang;

    /**
     * @var Rsc_Menu_Page
     */
    protected $menu;

    /**
     * @var Rsc_Resolver
     */
    protected $resolver;

    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * @var Rsc_Logger_Interface
     */
    protected $logger;

    /**
     * @var bool
     */
    protected $profilerEnabled;

    /**
     * @var Rsc_Dispatcher
     */
    protected $dispatcher;

	protected $adminAreaMenus = array();
	
	protected $baseModInited = false;

    /**
     * Constructor
     * @param string $pluginName Plugin name.
     * @param string $version Plugin version.
     * @param string $path Path to plugin.
     */
    public function __construct($pluginName, $version, $path)
    {
        $this->pluginName = $pluginName;
        $this->pluginPath = $path;

        /* Class loader */
        $this->loader = new Rsc_ClassLoader();

        /* Modules resolver */
        $this->resolver = new Rsc_Resolver($this);

        /* Config */
        $this->config = new Rsc_Config($this->defaults);
        $this->config->setDefaultPath(untrailingslashit($path) . '/app/configs');
        try {
            $this->config->load('@app/global.php');
        } catch (Exception $e) {}

        $this->config->add('plugin_name', $this->pluginName);
        $this->config->add('plugin_version', $version);
        $this->config->add('plugin_path', $path);

        /* Dispatcher */
        $this->dispatcher = new Rsc_Dispatcher($this);

        add_action('init', array($this, 'wpInitCallback'));
    }

	public function setBaseModInited( $newVal ) {
		$this->baseModInited = $newVal;
	}
	
	public function getBaseModInited() {
		return $this->baseModInited;
	}

    /**
     * Configure plugin environment
     * @param array $parameters An associative array with the parameters
     * @return Rsc_Environment
     */
    public function configure(array $parameters)
    {
        $this->config->merge($parameters);

        $this->config = apply_filters(
            sprintf('%s_after_configure', $this->pluginName),
            $this->config,
            $this
        );

        return $this;
    }

    /**
     * Run plugin
     */
    public function run()
    {
        $this->loader->add('BarsMaster', dirname(dirname(__FILE__)));
        $this->loader->add('Twig', dirname(dirname(__FILE__)));

        if ($this->config->has('plugin_prefix') && $this->config->has('plugin_source')) {
            $prefix = $this->config->get('plugin_prefix');
            $path = $this->config->get('plugin_source');

            $this->loader->add($prefix, $path);
        }

        $this->loader = apply_filters(
            sprintf('%s_before_loader_register', $this->pluginName),
            $this->loader,
            $this
        );

        $this->loader->register();

        /* Twig */
        try {
            $templatesPath = $this->getPluginPath() . '/app/templates';

            $this->twig = new Twig_Environment(
                new Twig_Loader_Filesystem($templatesPath),
                array(
                    'cache' => $this->config->get('plugin_cache_twig', false),
                    'debug' => $this->isDev(),
                )
            );


            if ($this->isDev()) {
                $this->twig->addExtension(new Twig_Extension_Debug());
            }
        } catch (Twig_Error_Loader $e) {
            wp_die(
                sprintf('Invalid plugin path specified: "%s"', $e->getMessage())
            );
        }

        $this->getLang()->loadTextDomain();

        /** @TODO THROW TRY CATCH */
        if ($this->config->has('plugin_menu')) {
            $this->menu = new Rsc_Menu_Page($this->resolver);

            foreach ($parameters = $this->config->get('plugin_menu') as $key => $value) {
                if (method_exists($this->menu, $method = sprintf('set%s', str_replace('_', '', $key)))) {
                    call_user_func_array(array($this->menu, $method), array($value));
                }
            }

            $this->menu = apply_filters(
                sprintf('%s_before_menu_register', $this->pluginName),
                $this->menu
            );

            //$this->menu->register();
        }

        $this->twig->addGlobal('environment', $this);
        $this->twig->addGlobal('request', new Rsc_Http_Request());

        $this->resolver = apply_filters(
            sprintf('%s_before_resolver_register', $this->pluginName),
            $this->resolver
        );

        $this->registerActivation();
        /* Do not edit this code in any case */
//        $this->fc320fde997f9bea5c39d56e094bfb99();
        add_action('plugins_loaded', array($this, 'extend'));
    }

	public function setAdminAreaMenus( $menus ) {
		$this->adminAreaMenus = $menus;
	}
	public function getAdminAreaMenus() {
		return $this->adminAreaMenus;
	}

    /**
     * Registers activation hook
     */
    public function registerActivation()
    {
        $index = $this->getPluginPath() . '/index.php';

        register_activation_hook($index, array($this->resolver, 'install'));
    }

    public function extend()
    {
        do_action($this->pluginName . '_plugin_loaded', $this);

        $this->resolver->init();
		if($this->menu) {
			$this->menu->register();
		}
    }

    public function isPro()
    {
        return $this->config->get('is_pro', false);
    }

    /**
     * Returns an instance of the Twig
     * @return Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * Returns an instance of the language class
     * @return Rsc_Lang
     */
    public function getLang()
    {
        if ($this->lang === null) {

            if (!$domain = $this->config->get('lang_domain')) {
                $domain = preg_replace("/[^a-z0-9_-]/", '', strtolower($this->pluginName));
                $this->config->add('lang_domain', $domain);
            }

            if (!$path = $this->config->get('lang_path')) {
                $path = plugin_basename(
                    dirname(dirname(dirname(__FILE__))) . '/app/langs'
                );

                $this->config->add('lang_path', $path);
            }

            $this->lang = new Rsc_Lang($domain, $path);
        }

        return $this->lang;
    }

    /**
     * Returns plugin environment configurations
     * @return Rsc_Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Returns an instance of the caching class
     * @return Rsc_Cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Returns ClassLoader
     * @return Rsc_ClassLoader
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Returns an instance of the current menu page
     * @return \Rsc_Menu_Page
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Returns an instance of the modules resolver
     * @return Rsc_Resolver
     */
    public function getResolver()
    {
        return $this->resolver;
    }

    /**
     * @param \Rsc_Logger_Interface $logger
     * @return Rsc_Environment
     */
    public function setLogger(Rsc_Logger_Interface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return \Rsc_Logger_Interface
     */
    public function getLogger()
    {
        return $this->logger;
    }


    /**
     * Returns the URL to the plugin page
     * @return null|string
     */
    public function getUrl()
    {
        if ($this->menu === null) {
            return null;
        }

        return admin_url(sprintf('admin.php?page=%s', $this->menu->getMenuSlug()));
    }

    /**
     * @param string $module The name of the module
     * @param string $action The name of the action (default indexAction)
     * @param array $parameters An associative array of the parameters
     * @return string
     */
    public function generateUrl($module, $action = 'index', array $parameters = array(), $hash = '')
    {
        $url = $this->getUrl() . '&module=' . strtolower($module);

        if (!empty($action) && $action != 'index') {
            $url .= '&action=' . $action;
        }

        if (!empty($parameters)) {
            $url .= '&' . http_build_query($parameters, '', '&');
        }

		if(!empty($hash)) {
			$url .= '#'. $hash;
		}

        return $url;
    }

    /**
     * Returns an instance of the specified module
     * @param string $module The name of the module
     * @return Rsc_Mvc_Module|null
     */
    public function getModule($module)
    {
        return $this->resolver->getModules()->get(strtolower($module));
    }

    /**
     * Translates specified text
     * @param string $msgid The text to translate
     * @return string|void
     */
    public function translate($msgid)
    {
        return $this->getLang()->translate($msgid);
    }

    /**
     * Set an instance of the caching class
     * @param Rsc_Cache_Interface $adapter
     * @return Rsc_Environment
     */
    public function setCacheAdapter(Rsc_Cache_Interface $adapter)
    {
        $this->cache = new Rsc_Cache($adapter);
        return $this;
    }

    /**
     * Set profiler state
     * @param boolean $profilerEnabled
     * @return Rsc_Environment
     */
    public function setProfilerEnabled($profilerEnabled)
    {
        $this->profilerEnabled = (bool)$profilerEnabled;
        return $this;
    }

    /**
     * Get profiler state
     * @return boolean
     */
    public function getProfilerEnabled()
    {
        return $this->profilerEnabled;
    }

    /**
     * Checks whether the current instance of the environment equals to the
     * specified.
     * @param string $environment
     * @return bool
     */
    public function is($environment)
    {
        return $this->config->isEnvironment($environment);
    }

    /**
     * Checks if current environment is production.
     *
     * @return bool
     */
    public function isProd()
    {
        return $this->is(self::ENV_PRODUCTION);
    }

    /**
     * Checks if current environment is development.
     *
     * @return bool
     */
    public function isDev()
    {
        return $this->is(self::ENV_DEVELOPMENT);
    }

    /**
     * Checks if currently opened plugin page.
     *
     * @return bool
     */
    public function isPluginPage()
    {
        $request  = new Rsc_Http_Request();
        $menuSlug = $this->menu->getMenuSlug();

        if ($menuSlug === null) {
            return false;
        }

        return (is_admin() && $menuSlug === $request->query->get('page'));
    }

    /**
     * Checks whether the current page is specified module and action.
     *
     * @param string $module Module name.
     * @param string $action Action name.
     * @return bool
     */
    public function isModule($module, $action = null)
    {
        $request = new Rsc_Http_Request();
        $default = $this->config->get('default_module');

        if (!$this->isPluginPage()) {
            return false;
        }

        if ($action === null) {
            return ($module === $request->query->get('module', $default));
        }

        return ($module === $request->query->get('module', $default)
            && $action === $request->query->get('action', 'index')
        );
    }

    /**
     * Checks whether the current page is specified action.
     *
     * @param string $action Action name.
     * @return bool
     */
    public function isAction($action)
    {
        $request = new Rsc_Http_Request();

        if (!$this->isPluginPage()) {
            return false;
        }

        return ($action === $request->query->get('action', 'index'));
    }

    /**
     * Returns plugin name.
     *
     * @return string
     */
    public function getPluginName()
    {
        return $this->pluginName;
    }

    /**
     * Returns event dispatcher
     *
     * @return \Rsc_Dispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * Returns the plugin path.
     *
     * @return string
     */
    public function getPluginPath()
    {
        return $this->pluginPath;
    }

    public function wpInitCallback()
    {
        $this->isWPInit = true;
    }

    public function isWPInit()
    {
        return $this->isWPInit;
    }

    /**
     * Sets the plugin path.
     *
     * @param string $pluginPath Path to the plugin.
     */
    public function setPluginPath($pluginPath)
    {
        $this->pluginPath = rtrim($pluginPath, DIRECTORY_SEPARATOR);
    }

    public function getProUrl($params = null) {
        $config = $this->config;

        return $config['page_url'] . (strpos($params, '?') === 0 ? '' : '?') . $params;
    }

    private function fc320fde997f9bea5c39d56e094bfb99()
    {
        add_filter(
            'pre_set_site_transient_update_plugins',
            array($this, 'a02d088e733f2a3cd06e8ae6bb441a29')
        );

        add_filter(
            'plugins_api',
            array($this, 'bf59a5cf52031db6c709c06104c159eb'),
            10,
            3
        );
    }

    public function a02d088e733f2a3cd06e8ae6bb441a29($checkedData)
    {
        return Rsc_Updater::getInstance(
            basename($this->getPluginPath()),
            'index.php',
            $this->getPluginName()
        )->checkForPluginUpdate($checkedData);
    }

    public function bf59a5cf52031db6c709c06104c159eb($def, $action, $args)
    {
        return Rsc_Updater::getInstance(
            basename($this->getPluginPath()),
            'index.php',
            $this->getPluginName()
        )->myPluginApiCall($def, $action, $args);
    }
	public function getLangCode2Letter() {
		$langCode = $this->getLangCode();
		return strlen($langCode) > 2 ? substr($langCode, 0, 2) : $langCode;
}
	public function getLangCode() {
		return get_locale();
	}
}
