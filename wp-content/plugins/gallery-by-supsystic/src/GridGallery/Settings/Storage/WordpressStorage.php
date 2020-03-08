<?php

/**
 * Class GridGallery_Settings_WordpressStorage
 * Implements the Settings Storage interface and provides access to the Wordpress Options API
 *
 * @see https://codex.wordpress.org/Options_API
 * @package GridGallery\Settings\Storage
 * @author Artur Kovalevsky
 */
class GridGallery_Settings_Storage_WordpressStorage implements GridGallery_Settings_SettingsStorageInterface
{

    /**
     * Adds new option to the storage
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function add($key, $value)
    {
        add_option($key, $value);
    }

    /**
     * Returns the value of the option
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return get_option($key, $default);
    }

    /**
     * Updates the value by the key
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        update_option($key, $value);
    }

    /**
     * Deletes option by the key
     *
     * @param string $key
     * @return void
     */
    public function delete($key)
    {
        delete_option($key);
    }

    /**
     * Returns all options
     *
     * @param string $prefix
     * @return array
     */
    public function all($prefix)
    {
        $options = wp_load_alloptions();
        $pluginOptions = array();

        foreach ($options as $key => $value) {
            if (substr($key, 0, $length = strlen($prefix)) === $prefix) {
                $pluginOptions[substr($key, $length)] = $value;
            }
        }

        return $pluginOptions;
    }
}