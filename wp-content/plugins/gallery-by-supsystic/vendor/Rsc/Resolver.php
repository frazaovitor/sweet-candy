<?php


class Rsc_Resolver
{

    /**
     * @var Rsc_Environment
     */
    private $environment;

    /**
     * @var Rsc_Common_Collection
     */
    protected $modules;

    /**
     * @var Rsc_Http_Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $routes;

    /**
     * @var array
     */
    protected $modulesList;

    /**
     * Constructor
     * @param Rsc_Environment $environment An instance of current environment
     */
    public function __construct(Rsc_Environment $environment)
    {
        $this->environment = $environment;
        $this->modules = new Rsc_Common_Collection();
        $this->request = new Rsc_Http_Request();
        $this->routes = array();
    }

    /**
     * Returns an instance of environment
     * @return Rsc_Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Returns the collection of the found modules
     * @return Rsc_Common_Collection
     */
    public function getModules()
    {
        return $this->modules;
    }

    public function setModules($modules)
    {
        if (is_array($modules)) {
            $modules = new Rsc_Common_Collection($modules);
        }

        $this->modules = $modules;
    }

    public function setRoute($slug, $module)
    {
        $this->routes[$slug] = $module;
        return $this;
    }

    /**
     * Installs the modules.
     */
    public function install()
    {
        $modules = $this->getModulesList();

        /** @var Rsc_Mvc_Module $module */
        foreach ($modules as $name => $module) {
            $module->onInstall();
        }
    }

    /**
     * Retrieves modules and doing initialization
     */
    public function init()
    {
        $config = $this->environment->getConfig();
        $hasHooksPrefix = $config->has('hooks_prefix');

        $modules = $this->getModulesList();

        /** @var Rsc_Mvc_Module $instance */
        foreach ($modules as $name => $instance) {
            /* Set http request to the module */
            $instance->setRequest($this->request)->onInit();

            /* Register hooks */
            $index = $this->environment->getPluginPath() . '/index.php';

            // register_activation_hook($index, array($instance, 'onInstall'));
            register_deactivation_hook($index, array($instance, 'onDeactivation'));

            if ($name === 'installer') {
                register_uninstall_hook($index, array(get_class($instance), 'onUninstall'));
            }
            
            /* We add module's location to the template & config loaders */

            /** @var Twig_Loader_Filesystem $loader */
            try {
                $loader = $this->environment->getTwig()->getLoader();
                $loader->addPath($instance->getLocation() . '/views', strtolower($name));

                // Add PRO module path to the @namespace.
                if ($instance->getOverloadController()) {
                    $prefix   = $config->get('pro_modules_prefix');
                    $location = $config->get('pro_modules_path')
                        . DIRECTORY_SEPARATOR
                        . $prefix
                        . DIRECTORY_SEPARATOR
                        . ucfirst($name);

                    $loader->addPath($location . '/views', strtolower($name) . '_pro');
                }
            } catch (Twig_Error_Loader $e) {  }

            $configLoader = $config->getLoader();
            $configLoader->add($instance->getLocation() . '/configs', strtolower($name));

            if ($instance->getOverloadController()) {
                $prefix   = $config->get('pro_modules_prefix');
                $location = $config->get('pro_modules_path')
                    . DIRECTORY_SEPARATOR
                    . $prefix
                    . DIRECTORY_SEPARATOR
                    . ucfirst($name);

                $configLoader->add($location . '/configs', strtolower($name) . '_pro');
            }

            /* Add module to the resolver */
            $this->modules->add(strtolower($name), $instance);

            if ($hasHooksPrefix) {
                do_action(
                    $config->get('hooks_prefix') . 'after_' . strtolower($name) . '_loaded',
                    $this->modules[strtolower($name)]
                );
            }

            // Try to load global configs for the current module.
            $basepath = $this->environment->getPluginPath()
                . '/app/configs';
            $filepath = '/modules/'
                . $instance->getModuleName()
                . '.php';

            if (file_exists($basepath . $filepath)) {
                $config = $this->environment->getConfig();
                $config->load($filepath);
            }
        }

        if ($hasHooksPrefix) {
            do_action($config->get('hooks_prefix') . 'after_modules_loaded');
        }
    }

    public function reinit()
    {
        if ($this->modules->isEmpty()) {
            return;
        }

        $twig   = $this->environment->getTwig()->getLoader();
        $config = $this->environment->getConfig();
        $loader = $config->getLoader();

        foreach ($this->modules as $name => $module) {
            if ($module->getOverloadController()) {
                $prefix   = $config->get('pro_modules_prefix');
                $location = $config->get('pro_modules_path')
                    . DIRECTORY_SEPARATOR
                    . $prefix
                    . DIRECTORY_SEPARATOR
                    . ucfirst($name);

                try {
                    $twig->addPath($location . '/views', $name . '_pro');
                } catch (Twig_Error_Loader $e) {
                    // Do nothing. Path does not exists.
                }

                $loader->add($location . '/configs', $name . '_pro');

                $module->setRequest($this->request);
                $module->onInit();
            }
        }
    }

    /**
     * Parses current routes and loads the module that matched for that route
     */
    public function resolve()
    {
        $query = $this->request->query;

        if (in_array($query->get('page'), array_keys($this->routes))) {
            $name = $this->routes[$query->get('page')];
        } else {
            /** @var Rsc_Mvc_Module $module */
            $name = $query->get('module', $this->environment->getConfig()->get('default_module'));
        }

        if (!$this->modules->has($name)) {
            wp_die ('The module that you requested is not found');
        }

        /** @var Rsc_Http_Response $response */
        $response = $module = $this->modules->get(strtolower($name))->setRequest($this->request)->handle();

        if (!is_object($response) || !$response instanceof Rsc_Http_Response) {
            wp_die ('The controller must return the response');
        }

        echo $response->getContent();
    }

    /**
     * Returns an array of modules from the cache if it exists
     * @return array|null
     */
    protected function getModulesFromCache()
    {
        return null;
    }

    /**
     * Saving an array of modules to the cache
     * @param array $modules
     */
    protected function setModulesCache(array $modules)
    {
        return null;
    }

    /**
     * Returns an array of found modules or NULL if at least one module did not found
     * @return array|null
     */
    public function getModulesList()
    {
        if (!$this->modulesList) {
            $modulesList     = array();
            $modulesLocation = array(
                array(dirname(dirname(__FILE__)), 'Rsc'),
                array(
                    $this->environment->getConfig()->get('plugin_source'),
                    $this->environment->getConfig()->get('plugin_prefix')
                ),
            );

            foreach ($modulesLocation as $locationData) {
                if (!in_array(null, $locationData) && count($locationData) == 2) {
                    list($path, $prefix) = $locationData;

                    $modules = $this->findModules($path, $prefix);

                    if (is_array($modules) && count($modules) > 0) {
                        $modulesList = array_merge($modulesList, $modules);
                    }
                }
            }

            $this->modulesList = new Rsc_Common_Collection($modulesList);
        }

        return $this->modulesList;
    }

    public function setModulesList($modulesList)
    {
        $this->modulesList = $modulesList;
    }

    protected function findModules($path, $prefix)
    {
        $modules = array();

        $nodes = glob(trailingslashit($path) . $prefix . '/*');

        if (empty($nodes) || $nodes === false) {
            return null;
        }

        foreach ($nodes as $node) {

            $node = str_replace('\\', '/', $node);

            if (is_dir($node) && file_exists($module = $node . '/Module.php')) {
                $classname = $prefix . '_' . basename($node) . '_Module';
                $name = strtolower(basename(dirname($module)));

                if ($name !== 'mvc') {
                    $modules[$name] = new $classname($this->environment, $node, $prefix);
                }
            }
        }

        return $modules;
    }
}
