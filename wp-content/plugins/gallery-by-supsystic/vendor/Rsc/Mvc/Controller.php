<?php


class Rsc_Mvc_Controller
{

    /**
     * @var Rsc_Environment
     */
    private $environment;

    /**
     * @var Rsc_Http_Request
     */
    private $request;

    /**
     * Constructor
     * @param Rsc_Environment $environment
     * @param Rsc_Http_Request $request
     */
    public function __construct(
        Rsc_Environment $environment,
        Rsc_Http_Request $request
    ) {
        $this->environment = $environment;
        $this->request = $request;
        $this->models = array();
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
            throw new BadMethodCallException(
                sprintf('Unexpected method: %s', $method)
            );
        }

        return call_user_func_array(
            array($this->environment, $method),
            $arguments
        );
    }

    /**
     * Creates new response
     * @param string $template The name of the template
     * @param array $data An associative array of the data
     * @return Rsc_Http_Response
     */
    public function response($template, array $data = array())
    {
        if ($template != Rsc_Http_Response::AJAX) {
            try {
                $twig = $this->environment->getTwig();
                $content = $twig->render($template, $data);
            } catch (Exception $e) {
                wp_die ($e->getMessage());
            }
        } else {
            wp_send_json($data);
        }

        return Rsc_Http_Response::create()->setContent($content);
    }

    /**
     * Generates the URL the to specified path
     * @param string $module The name of the module
     * @param string $action The name of the action
     * @param array $parameters An assoc array of parameters
     * @return string|void
     */
    public function generateUrl($module, $action = 'index', array $parameters = array())
    {
        $parameters = (!empty($parameters) ? '&' . http_build_query($parameters) : null);
        $slug = $this->getEnvironment()->getMenu()->getMenuSlug();

        return admin_url('admin.php?page=' . $slug . '&module=' . $module . '&action=' . $action . $parameters);
    }

    /**
     * Makes redirects to the specified URL
     * @param string $url
     * @return \Rsc_Http_Response
     */
    public function redirect($url)
    {
        if (!headers_sent()) {
            header(sprintf('Location: %s', $url));
            exit;
        }

        $content = "<script type=\"text/javascript\">document.location.href = '$url'</script>";

        return Rsc_Http_Response::create()->setContent($content);
    }

    /**
     * Returns an instance of the environment
     * @return \Rsc_Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Returns an instance of the current request
     * @return \Rsc_Http_Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    public function requireNonces() {
        return array();
    }
}
