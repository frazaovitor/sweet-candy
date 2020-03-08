<?php


class Rsc_Mvc_Model
{

    /**
     * @var wpdb
     */
    protected $db;

    /**
     * Constructor
     */
    public function __construct()
    {
        global $wpdb;

        $this->db = $wpdb;
    }

    /**
     * Do query with the dbDelta function
     * @param string $query MySQL query
     * @return mixed
     */
    public function delta($query)
    {
        if (!function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        return @dbDelta($query);
    }

    /**
     * Returns an instance of Query Builder
     * @return BarsMaster_ChainQueryBuilder
     */
    public function getQueryBuilder()
    {
        return new BarsMaster_ChainQueryBuilder();
    }

    /**
     * Returns an instance of Wpdb
     * @return \wpdb
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Returns the database connection resource if it is accessible
     * @return null|resource
     */
    public function getDatabaseHandler()
    {
        if ($this->isAccessibleDbConnection()) {
            return $this->db->dbh;
        }

        return null;
    }

    /**
     * Checks whether the table is exists
     * @param string $table The name of the table
     * @return bool TRUE if the table is exists, FALSE otherwise
     */
    public function isTableExists($table)
    {
        return ($this->db->get_var(sprintf('SHOW TABLES LIKE %s', $table)) == $table);
    }

    /**
     * Checks whether we can access to the database connection
     * @return bool TRUE if we can, FALSE otherwise
     */
    public function isAccessibleDbConnection()
    {
        if (!method_exists($this->db, '__get')) {
            return false;
        }

        if (!is_resource($this->db->dbh)) {
            return false;
        }

        return true;
    }
} 