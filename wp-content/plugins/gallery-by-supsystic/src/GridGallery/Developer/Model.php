<?php

/**
 * Class GridGallery_Developer_Model
 *
 * @package GridGallery\Developer
 * @author Artur Kovalevsky
 */
class GridGallery_Developer_Model extends Rsc_Mvc_Model
{

    /**
     * Returns the data about WordPress
     * @return array
     */
    public function getWordpressData()
    {
        global $wp_version, $wp_db_version;

        return array(
            'version' => $wp_version,
            'db_revision' => $wp_db_version,
            'locale' => get_locale(),
        );
    }

    /**
     * Returns the data about PHP
     * @return array
     */
    public function getPhpData()
    {
        return array(
            'version' => PHP_VERSION,
            'zend_version' => zend_version(),
            'operating_system' => php_uname(),
            'memory_limit' => ini_get('memory_limit'),
            'disabled_functions' => implode(', ', explode(',', ini_get('disable_functions'))),
            'extensions' => implode(', ', get_loaded_extensions()),
        );
    }

} 