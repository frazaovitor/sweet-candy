<?php


class Rsc_Config_Loader
{

    const DEFAULT_NAMESPACE = 'app';

    /**
     * @var array
     */
    protected $paths;

    /**
     * Adds
     * @param string $path
     * @param string $namespace
     * @return Rsc_Config_Loader
     */
    public function add($path, $namespace = self::DEFAULT_NAMESPACE)
    {
        if (!isset($this->paths[$namespace])) {
            $this->paths[$namespace] = null;
        }

        if (!is_array($this->paths[$namespace])) {
            $this->paths[$namespace] = array();
        }

        $this->paths[$namespace] = array_merge(
            $this->paths[$namespace],
            (array)untrailingslashit($path)
        );

        return $this;
    }

    /**
     * Deletes
     * @param string $namespace Namespace
     * @return bool
     */
    public function delete($namespace)
    {
        if (isset($this->paths[$namespace])) {
            unset ($namespace);
            return true;
        }

        return false;
    }

    /**
     * @param string $file The full path to the file
     * @return array
     * @throws Rsc_Exception_ConfigLoaderException
     */
    public function load($file)
    {

        if (!$this->isNamespaced($file)) {
            $file = $this->getDefaultNamespacePath($file);
        }

        try {
            return $this->loadFromNamespace($file);
        } catch (Exception $e) {
            throw new Rsc_Exception_ConfigLoaderException(sprintf(
                'Unable to load config %s: %s',
                $file,
                $e->getMessage()
            ));
        }
    }

    /**
     * @param string $pattern The pattern of the namespace
     * @param string $namespace Namespace
     * @param string $path Path to the file
     * @return array
     */
    protected function getVariants($pattern, $namespace, $path)
    {
        $variants = array();

        foreach ($this->paths[$namespace] as $dir) {
            $variants[] = $dir . str_replace($pattern, DIRECTORY_SEPARATOR, $path);
        }

        return $variants;
    }

    /**
     * Loads the file from the namespace
     * @param string $filename
     * @return array
     * @throws RuntimeException if the file does not exists
     * @throws InvalidArgumentException If the file has not namespace
     */
    protected function loadFromNamespace($filename)
    {
        if (!preg_match('/@([a-z_]*)\//', $filename, $matches)) {
            throw new InvalidArgumentException(sprintf(
                'The file %s is not has the namespace',
                $filename
            ));
        }

        list($pattern, $namespace) = (is_array($matches[0]) ? $matches[0] : $matches);

        if (!$this->hasNamespace($namespace)) {
            throw new InvalidArgumentException(sprintf(
                'The namespace %s does not exists',
                $namespace
            ));
        }

        $variants = $this->getVariants($pattern, $namespace, $filename);
        foreach ($variants as $variant) {
            if (is_file($variant) && is_readable($variant)) {
                if (!is_array($config = include $variant)) {
                    throw new RuntimeException('The configuration file must return an array.');
                }

                return $config;
            }
        }

        throw new RuntimeException(sprintf(
            'The file %s is does not exists',
            $filename
        ));
    }

    /**
     * Prepends the default namespace
     * @param string $file Path to the file
     * @return string
     */
    protected function getDefaultNamespacePath($file)
    {
        return sprintf('@%s/%s', self::DEFAULT_NAMESPACE, ltrim($file, '/'));
    }

    /**
     * Checks whether the path has  the namespace
     * @param string $path Path to teh file
     * @return bool
     */
    protected function isNamespaced($path)
    {
        return (preg_match('/@([a-z_]*)\//', $path) ? true : false);
    }

    /**
     * Checks if the given namespace exists
     * @param string $namespace
     * @return bool
     */
    protected function hasNamespace($namespace)
    {
        return (isset($this->paths[$namespace]));
    }

    /**
     * Returns the paths from the namespace
     * @param string $namespace
     * @return array|null
     */
    protected function getPaths($namespace)
    {
        return ($this->hasNamespace($namespace) ? $this->paths[$namespace] : null);
    }
}
