<?php


class Rsc_Mvc_Module
{

    /**
     * @var Rsc_Environment
     */
    private $environment;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var Rsc_Http_Request
     */
    private $request;

    /**
     * @var Rsc_Mvc_Controller
     */
    private $controller;

    /**
     * @var bool
     */
    private $overloadController;

    /**
     * Constructor.
     * @param Rsc_Environment $environment An instance of the current environment
     * @param string          $location    Full path to the directory where is module
     * @param string          $namespace   Module prefix
     */
    public function __construct(Rsc_Environment $environment, $location, $namespace)
    {
        $this->environment = $environment;
        $this->location    = $location;
        $this->namespace   = $namespace;

        $this->overloadController = false;
    }

    /**
     * @param string $method The name of the method
     * @param array $arguments An array of arguments
     * @return mixed
     * @throws BadMethodCallException If specified method does not exists
     */
    public function __call($method, $arguments)
    {
        if (!method_exists($this->environment, $method)) {
            throw new BadMethodCallException(sprintf('Unexpected method: %s', $method));
        }

        return call_user_func_array(array($this->environment, $method), $arguments);
    }

    /**
     * Returns an instance of the current environment
     * @return Rsc_Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Returns full path to the directory where is module
     * @return string
     */
    public function getLocation()
    {
        return str_replace('\\', '/', $this->location);
    }

    /**
     * Returns the url to the current module's page or NULL if the menu page is not configured
     * @return null|string
     */
    public function getUrl()
    {
        if (null !== $url = $this->environment->getUrl()) {
            return $url . '&module=' . end(explode('_', strtolower(basename($this->location))));
        }

        return null;
    }

    /**
     * Returns the URL to the module location
     * @return string
     */
    public function getLocationUrl()
    {
		$path = plugin_basename($this->location);
		return plugins_url($path);
    }

    /**
     * Returns the name of the current module
     * @return string
     */
    public function getModuleName()
    {
        return strtolower(basename($this->location));
    }

    /**
     * Returns an instance of controller
     * @return null|Rsc_Mvc_Controller
     */
    public function getController()
    {
        if ($this->controller === null) {
            $this->createController();
        }

        return $this->controller;
    }

    /**
     * Returns the HTTP request to the module
     * @return Rsc_Http_Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set HTTP request to the module
     * @param Rsc_Http_Request $request HTTP request
     * @return Rsc_Mvc_Module
     */
    public function setRequest(Rsc_Http_Request $request)
    {
        $this->request = $request;
        return $this;
    }

    public function handle()
    {
        $action = $this->request->query->get('action', 'index') . 'Action';

        $controller = $this->getController();

        if (method_exists($controller, $action)) {

            $requireNonces = $controller->requireNonces();

            if (in_array($action, $requireNonces)) {
				$plugMenuSets = $this->getEnvironment()->getConfig()->get('plugin_menu');
				check_admin_referer($plugMenuSets['menu_slug']);
            }

            return call_user_func_array(array($controller, $action), array(
                $this->request
            ));
        }

        $twig = $this->environment->getTwig();

		return Rsc_Http_Response::create()->setContent($twig->render('404.twig', array(
			'controller' => $this->getModuleName(),
			'action' => $action,
		)));
    }

    /**
     * Triggered when the resolver doing initialization of module
     */
    public function onInit()
    {

    }

    /**
     * Triggered on plugin activation
     */
    public function onInstall()
    {

    }

    /**
     * Triggered on plugin uninstall
     */
    public static function onUninstall()
    {

    }

    /**
     * Triggered on plugin deactivation
     */
    public function onDeactivation()
    {

    }

    /**
     * @param $overloadController
     *
     * @return $this
     */
    public function setOverloadController($overloadController)
    {
        $this->overloadController = (bool)$overloadController;

        return $this;
    }

    public function getOverloadController()
    {
        return $this->overloadController;
    }

    /**
     * Creates controllers.
     *
     * @return bool
     */
    private function createController()
    {
        $config = $this->getEnvironment()->getConfig();

        $prefix = $this->namespace;
        $path   = $this->location;
        $module = ucfirst($this->getModuleName());

        if ($this->overloadController) {
            $prefix = $config->get('pro_modules_prefix');
            $path   = $config->get('pro_modules_path')
                . '/'
                . $prefix
                . '/'
                . $module;
        }

        $classname = $prefix . '_' . $module . '_Controller';

        if (!is_file($path . '/Controller.php') || !class_exists($classname)) {
            return false;
        }

        $this->controller = new $classname($this->environment, $this->request);

        return true;
    }

}
