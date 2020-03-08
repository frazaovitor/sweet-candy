<?php

/**
 * Class GridGallery_Photos_Model_Settings
 * The model that provides logic to work with the settings for photos module
 * All settings are stored in the table photos_settings
 *
 * @package GridGallery\Photos\Model
 * @author Artur Kovalevsky
 */
class GridGallery_Photos_Model_Settings extends Rsc_Mvc_Model
{

    /**
     * @var bool
     */
    protected $debugEnabled;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $lastError;

    /**
     * Constructor
     * @param bool $debugEnabled
     */
    public function __construct($debugEnabled = false)
    {
        parent::__construct();

        $this->debugEnabled = $debugEnabled;
        $this->table = $this->db->prefix . 'gg_photos_settings';

        if ($this->debugEnabled) {
            $tables = array_keys($this->db->get_results('SHOW TABLES', OBJECT_K));

            if (!in_array($this->table, $tables)) {
                wp_die(sprintf('Invalid table %s specified in the model %s', $this->table, __CLASS__));
            }
        }
    }

    /**
     * Enables debug
     * @param boolean $debugEnabled
     * @return GridGallery_Photos_Model_Settings
     */
    public function setDebugEnabled($debugEnabled)
    {
        $this->debugEnabled = $debugEnabled;
        return $this;
    }

    /**
     * Returns the last error
     * @return string
     */
    public function getLastError()
    {
        return $this->lastError;
    }

    /**
     * Returns the all parameters for the photos
     * @return array|null
     */
    public function getAll()
    {
        $query = $this->getQueryBuilder()->select('*')
            ->from($this->table);

        if (!$parameters = $this->db->get_results($query->build())) {
            return null;
        }

        foreach ($parameters as $index => $parameter) {
            unset ($parameters[$index]);
            $parameters[$parameter->name] = $parameter;
        }

        return $parameters;
    }

    /**
     * Returns parameter's value by name
     * @param string $name The name of the parameter
     * @return string|null
     */
    public function get($name)
    {
        $query = $this->getQueryBuilder()->select('*')
            ->from($this->table)
            ->where('name', '=', $name);

        if (!$parameter = $this->db->get_row($query->build())) {

            if ($this->debugEnabled) {
                wp_die(sprintf('Trying to get undefined photos parameter \'%s\'', $name));
            }

            return null;
        }

        return $parameter->value;
    }

    /**
     * Updates parameter by name
     * @param string $name The name of the parameter
     * @param mixed $value New value
     * @return bool TRUE on success, FALSE otherwise
     */
    public function update($name, $value)
    {
        $query = $this->getQueryBuilder()->update($this->table)
            ->fields('value')
            ->values($value)
            ->where('name', '=', $name);

        if (false === $this->db->query($query->build())) {
            $this->lastError = $this->db->last_error;
            return false;
        }

        return true;
    }
}