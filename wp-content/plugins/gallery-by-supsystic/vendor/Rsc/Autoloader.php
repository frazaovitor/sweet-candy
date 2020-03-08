<?php


class Rsc_Autoloader
{

    /**
     * Register Rsc_Autoloader in the SPL autoloader stack
     */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'load'));
    }

    /**
     * Load the specified class
     * @param string $classname Name of the class to be loaded
     */
    public static function load($classname)
    {
        if (substr($classname, 0, 3) !== 'Rsc') {
            return;
        }

        if (is_file($file = dirname(__FILE__) . '/../' . str_replace(array('_', '\0'), array('/', ''), $classname) . '.php')) {
            require $file;
        }
    }

} 