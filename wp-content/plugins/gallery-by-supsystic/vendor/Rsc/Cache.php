<?php


class Rsc_Cache
{

    /**
     * @var Rsc_Cache_Interface
     */
    protected $adapter;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var int
     */
    protected $ttl;

    /**
     * Constructor
     * @param Rsc_Cache_Interface $adapter The caching adapter
     */
    public function __construct(Rsc_Cache_Interface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Adds data to the cache
     * @param string $key The key for the cached data
     * @param mixed $data The data for the cache
     * @return bool TRUE on success, FALSE otherwise
     */
    public function set($key, $data)
    {
        return $this->adapter->set($this->prefix . $key, $data, $this->ttl);
    }

    /**
     * Get the cached data by the specified key
     * @param string $key The key for the cached data
     * @return mixed|null The cached data of NULL on failure or if the cached data is not fresh
     */
    public function get($key)
    {
        return $this->adapter->get($this->prefix . $key);
    }

    /**
     * Deletes the cached data for the specified key
     * @param string $key The key for the cached data
     * @return bool TRUE on success, FALSE otherwise
     */
    public function delete($key)
    {
        return $this->adapter->delete($this->prefix . $key);
    }

    /**
     * Clears the cache
     * @return bool TRUE on success, FALSE otherwise
     */
    public function clear()
    {
        return $this->adapter->clear();
    }

    /**
     * Sets the prefix for keys
     * @param string $prefix
     * @return Rsc_Cache
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * Returns the prefix for keys
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Sets the time to life for cached data
     * @param int $ttl
     * @return Rsc_Cache
     */
    public function setTtl($ttl)
    {
        $this->ttl = (int)$ttl;
        return $this;
    }

    /**
     * Returns the time to life for cached data
     * @return int
     */
    public function getTtl()
    {
        return $this->ttl;
    }

} 