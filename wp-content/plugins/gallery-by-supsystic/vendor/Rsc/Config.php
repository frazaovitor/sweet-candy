<?php


class Rsc_Config extends Rsc_Common_Collection
{

    /**
     * @var Rsc_Config_Loader
     */
    protected $loader;

    /**
     * @var Rsc_Config_ListenerInterface[]
     */
    protected $listener;

    /**
     * Constructor
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        parent::__construct($config);

        $this->loader = new Rsc_Config_Loader();
    }

    /**
     * Returns plugin environment
     * @return string
     */
    public function getEnvironment()
    {
        return $this->get('environment');
    }

    /**
     * Checks whether specified environment is equal with current environment
     * @param $environment
     * @return bool TRUE if equal, FALSE otherwise
     */
    public function isEnvironment($environment)
    {
        return ($this->getEnvironment() === $environment);
    }


    /**
     * Loads the specified configuration file
     * @param string $filename
     * @return bool
     */
    public function load($filename)
    {
        try {
            $this->merge($this->loader->load($filename));
            return true;
        } catch(Rsc_Exception_ConfigLoaderException $e) {
            if ($this->isEnvironment(Rsc_Environment::ENV_DEVELOPMENT)) {
                wp_die ($e->getMessage());
            }

            return false;
        }
    }

    /**
     * Returns the instance of the config loader
     * @return Rsc_Config_Loader
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Adds the listener
     * @param string $name The unique name of the listener
     * @param Rsc_Config_ListenerInterface $listener
     * @return Rsc_Config
     */
    public function addListener($name, Rsc_Config_ListenerInterface $listener)
    {
        $this->listener[$name] = $listener;
        return $this;
    }

    /**
     * Deletes the listener
     * @param string $name The unique name of the listener
     */
    public function deleteListener($name)
    {
        if (isset($this->listener[$name])) {
            unset ($this->listener[$name]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        $this->callListener('onGet', $key);

        return parent::get($key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->callListener('onUpdate', $key, $value);

        return parent::set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value)
    {
        $this->callListener('onAdd', $key, $value);

        return parent::add($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key)
    {
        $this->callListener('onDelete', $key);

        return parent::delete($key);
    }

    protected function callListener($method, $key, $value = null)
    {
        if (empty($this->listener)) {
            return;
        }

        foreach ($this->listener as $listener) {
            call_user_func_array(array($listener, $method), array($key, $value));
        }
    }

    /**
     * Sets the global config path.
     *
     * @param string $defaultPath Default namespace path.
     */
    public function setDefaultPath($defaultPath)
    {
        $loader = $this->getLoader();

        $loader->add($defaultPath, Rsc_Config_Loader::DEFAULT_NAMESPACE);
    }
} 