<?php


class Rsc_Http_Request
{
    /**
     * @var Rsc_Http_Parameters
     */
    public $post;

    /**
     * @var Rsc_Http_Parameters
     */
    public $query;

    /**
     * @var Rsc_Http_Parameters
     */
    public $files;

    /**
     * @var Rsc_Http_ServerParameters
     */
    public $server;

    /**
     * @var Rsc_Http_Parameters
     */
    public $headers;

    /**
     * Constructor
     */
    public function __construct()
    {
		$postTempVar = $_POST;
		if(!empty($_POST) && is_string($_POST)) {
			$postTempVar = unserialize($_POST);
		}
		if(!is_array($postTempVar)) {
			$postTempVar = array();
		}
		$this->post = new Rsc_Http_Parameters($postTempVar);
        $this->query = new Rsc_Http_Parameters($_GET);
        $this->files = new Rsc_Http_Parameters($_FILES);
        $this->server = new Rsc_Http_ServerParameters($_SERVER);
        $this->headers = new Rsc_Http_Parameters($this->server->getHeaders());
    }

    /**
     * Returns new request from the global variables
     * @return Rsc_Http_Request
     */
    public static function create()
    {
        return new self();
    }

    /**
     * Is XMLHttpRequest?
     * @return bool
     */
    public function isXmlHttpRequest()
    {
        return ($this->server->has('X_REQUESTED_WITH') && 'XMLHttpRequest' === $this->server->get('X_REQUESTED_WITH'));
    }

    /**
     * Is AJAX request?
     * @return bool
     */
    public function isAjax()
    {
        return $this->isXmlHttpRequest();
    }

    /**
     * Returns an array of supported locales of the user or null if this data are not specified
     * @return array|null
     */
    public function getUserLocales()
    {
        preg_match_all('/[a-z]{2}-[A-Z]{2}/', $this->headers->get('ACCEPT_LANGUAGE'), $locales);

        return (isset($locales[0]) ? $locales[0] : null);
    }

    /**
     * Returns an array of supported languages of the user or NULL if this data are not specified
     * @return array|null
     */
    public function getUserLanguages()
    {
        $languages = array();

        if (null === $locales = $this->getUserLocales()) {
            return null;
        }

        foreach ($locales as $locale) {
            $languages[] = reset(explode('-', $locale));
        }

        return $languages;
    }

    /**
     * Returns the name of the browser
     * @return string|null
     */
    public function getUserAgent()
    {
        $userAgent = $this->headers->get('USER_AGENT');

        preg_match_all('/msie|firefox|safari|opera|chrome/i', $userAgent, $browser);

        return (isset($browser[0]) ?  reset($browser[0]) : null);
    }

    /**
     * Checks whether specified browser name equals to the user's browser
     * @param string $browser Name of the browser
     * @return bool
     */
    public function isBrowser($browser)
    {
        return (strtolower($browser) === strtolower($this->getUserAgent()));
    }

    /**
     * Returns the name of the user operating system
     * @return string|null
     */
    public function getUserOs()
    {
        $userAgent = $this->headers->get('USER_AGENT');

        preg_match_all('/windows|macintosh|linux|freebsd|unix|iphone/i', $userAgent, $os);

        return (isset($os[0]) ? reset($os[0]) : null);
    }
}