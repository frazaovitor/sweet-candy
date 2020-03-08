<?php


class Rsc_Cache_Dummy implements Rsc_Cache_Interface
{

    /**
     * Caches data
     * @param string $key The key
     * @param mixed $data Data for caching
     * @param int $ttl Lifetime of the cached data
     * @return bool TRUE if the data is successfully written to the cache, FALSE otherwise
     */
    public function set($key, $data, $ttl = 3600)
    {
        return true;
    }

    /**
     * Returns data from the cache if it is fresh
     * @param string $key The key
     * @return mixed|null Cached data or NULL if the lifetime of the cache has expired or data not found
     */
    public function get($key)
    {
        return null;
    }

    /**
     * Remove cached data
     * @param string $key The key
     * @return bool TRUE on success, FALSE otherwise
     */
    public function delete($key)
    {
        return true;
    }

    /**
     * Clear the cache
     * @return bool TRUE on success, FALSE otherwise
     */
    public function clear()
    {
        return true;
    }
}