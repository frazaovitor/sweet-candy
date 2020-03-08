<?php

/**
 * Class GridGallery_Ajax_Handler
 * AJAX requests handler
 *
 * @package GridGallery\Ajax
 * @author Artur Kovalevsky
 */
class GridGallery_Ajax_Handler
{

    /**
     * @var Rsc_Environment
     */
    protected $environment;

    /**
     * @param Rsc_Environment $environment
     */
    public function __construct(Rsc_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return bool
     */
    public function handle()
    {
        $request = Rsc_Http_Request::create();

        if ($this->isPostRequest($request)) {
            return $this->handleRequest($request->post);
        } elseif ($this->isGetRequest($request)) {
            return $this->handleRequest($request->query);
        }
    }

    /**
     * @param Rsc_Http_Parameters $method
     * @return bool
     */
    public function handleRequest(Rsc_Http_Parameters $method)
    {
        /** @var Rsc_Mvc_Module $module */
        if (!$method->has('route')) {
            return false;
        }
		
        check_ajax_referer('supsystic-gallery');

        $allowedRoles = array('administrator');

        $settings = get_option($this->environment->getConfig()->get('db_prefix') . 'settings');

        if ($settings && isset($settings['access_roles'])) {
            $allowedRoles = array_merge($allowedRoles, $settings['access_roles']);  
        }

        $currentUser = wp_get_current_user();

        if (empty($currentUser->roles)) {
            return false;
        } else {
            $matched = array_intersect($currentUser->roles, $allowedRoles);

            if (empty($matched) && !current_user_can('manage_options')) {
               return false;
            }
        }

        $route = $method->get('route');
        $module = (isset($route['module']) ? $route['module'] : $this->environment->getConfig()->get('default_module'));
        $action = (isset($route['action']) ? $route['action'] : 'index');

        if (null !== $module = $this->environment->getModule(strtolower($module))) {
            $controller = $module->getController();

            if ($controller !== null && method_exists($controller, $action = sprintf('%sAction', $action))) {
                return call_user_func_array(array($controller, $action), array($controller->getRequest()));
            }
        }

        return false;
    }

    /**
     *
     * @param Rsc_Http_Request $request
     * @return bool
     */
    public function isPostRequest(Rsc_Http_Request $request)
    {
        return ($request->post->has('route'));
    }

    /**
     * @param Rsc_Http_Request $request
     * @return bool
     */
    public function isGetRequest(Rsc_Http_Request $request)
    {
        return ($request->query->has('route'));
    }
} 