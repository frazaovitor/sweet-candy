<?php


class Rsc_Cache_Filesystem implements Rsc_Cache_Interface
{

    /**
     * @var string
     */
    protected $path;

    /**
     * Constructor
     * @param string $path The path where the cached data will be saved
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $data, $ttl = 3600)
    {
        if (is_dir($this->path) && is_writable($this->path)) {
            $cache = array(
                'data'    => serialize($data),
                'expires' => time() + (int)$ttl,
            );

            if (file_put_contents(trailingslashit($this->path) . $this->sanitizeKey($key), serialize($cache))) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        if (file_exists($file = trailingslashit($this->path) . $this->sanitizeKey($key))) {
            $cache = unserialize(file_get_contents($file));

            if (!$this->isFresh($cache['expires'])) {
                $this->delete($key);
                return null;
            }

            return unserialize($cache['data']);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key)
    {
        if (file_exists($file = trailingslashit($this->path) . $this->sanitizeKey($key))) {
            return unlink($file);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $nodes = glob(trailingslashit($this->path) . '*');

        if (!is_array($nodes) || count($nodes) < 1) {
            return false;
        }

        foreach ($nodes as $node) {
            if (is_file($node)) {
                unlink($node);
            }
        }

        return true;
    }

    /**
     * Expired lifetime or not
     * @param int $expires Expiration time
     * @return bool TRUE if not expired, FALSE otherwise
     */
    public function isFresh($expires)
    {
        return ((int)$expires > time());
    }

    /**
     * Sanitize specified key
     * @param string $key The key
     * @return string Sanitized key
     */
    protected function sanitizeKey($key)
    {
        return preg_replace("/[^A-Za-z0-9_-]/", '', $key);
    }
}