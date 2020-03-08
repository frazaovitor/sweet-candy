<?php

/**
 * Class GridGallery_Stats_Model
 * @package GridGallery\Stats
 */
class GridGallery_Stats_Model extends GridGallery_Core_BaseModel
{

    const MAX_VISITS = 10;
    //const PLUGIN_CODE = 'ggp';

    protected $pluginCode;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * Constructor
     * @param bool $debugEnabled
     */
    public function __construct($debugEnabled, $code)
    {
        parent::__construct((bool)$debugEnabled);

        $this->table = $this->db->prefix . 'gg_stats';
        $this->pluginCode = $code;
    }

    /**
     * Saves the action.
     * @param string $action The name of the action.
     */
    public function save($action)
    {
        if (!$this->exists($action)) {
            $this->insert($action);
            return;
        }

        $this->update($action);
    }

    /**
     * Returns the all usage stats.
     * @return array
     */
    public function get()
    {
        $query = $this->getQueryBuilder();
        $query->select('*')->from($this->table);

        return $this->db->get_results($query->build(), ARRAY_A);
    }

    /**
     * Clears the stats.
     */
    public function clear()
    {
        $query = $this->getQueryBuilder();
        $query->deleteFrom($this->table);

        $this->db->query($query->build());
    }

    /**
     * Sends the usage stats.
     * @return bool
     */
    public function send()
    {
        $data = $this->get();

        $response = wp_remote_post(
            $this->getApiUrl(),
            array(
                'body' => array(
                    'site_url' => get_bloginfo('wpurl'),
                    'site_name' => get_bloginfo('name'),
                    'plugin_code' => $this->pluginCode,
                    'all_stat' => $data,
                ),
            )
        );

        if (is_wp_error($response)) {
            if ($this->logger) {
                $this->logger->error(
                    'Failed to send usage statistics: {error}',
                    array('error' => $response->get_error_message())
                );
            }

            return false;
        }

        return true;
    }

    /**
     * Inserts the new action to the database.
     * @param string $action The name of the action.
     */
    public function insert($action)
    {
        $query = $this->getQueryBuilder();

        $query->insertInto($this->table)
            ->fields('code', 'visits')
            ->values($action, 1);

        $this->db->query($query->build());
    }

    /**
     * Updates the specified action in the database.
     * @param string $action The name of the action.
     */
    public function update($action)
    {
        $query = $this->getQueryBuilder();
        $visits = $this->getVisits($action);

        $query->update($this->table)
            ->where('code', '=', $action)
            ->fields('visits')
            ->values((int)$visits + 1);

        $this->db->query($query->build());
    }

    /**
     * Counts the action.
     * @param string $action The name of the action.
     * @return int
     */
    public function exists($action)
    {
        $query = $this->getQueryBuilder();

        $query->select('*')
            ->from($this->table)
            ->where('code', '=', $action);

        $data = $this->db->get_results($query->build());
        if (empty($data)) {
            return false;
        }

        return true;
    }

    /**
     * Returns the action's "visits".
     * @param string $action The name of the action.
     * @return int
     */
    public function getVisits($action)
    {
        $query = $this->getQueryBuilder();

        $query->select('visits')
            ->from($this->table)
            ->where('code', '=', $action);

        if (null !== $data = $this->db->get_row($query->build())) {
            return $data->visits;
        }

        return 0;
    }

    /**
     * Checks whether the one of the action has more then MAX_VISITS visits.
     * @return bool
     */
    public function isReadyToSend()
    {
        $query = $this->getQueryBuilder();

        $query->select('*')
            ->from($this->table);

        $data = $this->db->get_results($query->build());
        if (empty($data)) {
            return false;
        }

        foreach ($data as $action) {
            if ($action->visits >= self::MAX_VISITS) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getApiUrl()
    {
        if (!$this->apiUrl) {
            $this->apiUrl = 'aHR0cDovLzU0LjY4LjE5MS4yMTcvP21vZD1vcHRpb25zJmFjdGlvbj1zYXZlVXNhZ2VTdGF0JnBsPXJjcw==';
        }

        return base64_decode($this->apiUrl);
    }
}
