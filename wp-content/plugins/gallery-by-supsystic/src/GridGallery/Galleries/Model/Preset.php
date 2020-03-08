<?php

/**
 * Class GridGallery_Galleries_Model_Preset
 * @package GridGallery\Galleries\Model
 */
class GridGallery_Galleries_Model_Preset extends GridGallery_Core_BaseModel
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var GridGallery_Galleries_Model_Settings
     */
    protected $settingsModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->table = $this->db->prefix . 'gg_settings_presets';
    }

    /**
     * Saves the preset.
     * @param int $id Settings ID.
     * @param string $title Preset title.
     * @return bool
     */
    public function set($settingsId, $title)
    {
        $title = htmlspecialchars($title, ENT_QUOTES, get_bloginfo('charset'));

        $query = $this->getQueryBuilder()->insertInto($this->table)
            ->fields('settings_id', 'title')
            ->values((int)$settingsId, $title);

        if (false === $this->db->query($query->build())) {
            return false;
        }

        return true;
    }

    /**
     * Removes the preset.
     * @param int $id Preset ID.
     * @return bool
     */
    public function remove($presetId)
    {
        $query = $this->getQueryBuilder()->deleteFrom($this->table)
            ->where('id', '=', (int)$presetId);

        if (false === $this->db->query($query->build())) {
            return false;
        }

        return true;
    }

    /**
     * Returns all presets.
     * @return array|null
     */
    public function getAll()
    {
        $query = $this->getQueryBuilder()->select('*')
            ->from($this->table);

        if (false === $presets = $this->db->get_results($query->build())) {
            throw new RuntimeException(
                sprintf('Failed to get presets: %s', $this->getLastError())
            );
        }

        if (is_array($presets)) {
            $presets = array_map(array($this, 'extend'), $presets);
        }

        return $presets;
    }

    /**
     * Returns the preset by the ID.
     * @param int $presetId Preset Id.
     * @return object|null
     */
    public function getById($presetId)
    {
        return $this->getBy('id', (int)$presetId);
    }

    /**
     * Returns the preset by the settings Id.
     * @param string $settingsId Settings id.
     * @return object|null
     */
    public function getBySettingsId($settingsId)
    {
        return $this->getBy('settings_id', (int)$settingsId);
    }

    /**
     * Lazy loading method for settings model.
     * @return GridGallery_Galleries_Model_Settings
     */
    protected function getSettingsModel()
    {
        if (!$this->settingsModel) {
            $this->settingsModel = $this->createSettingsModel();
        }

        return $this->settingsModel;
    }

    /**
     * Factory method to create the settings model.
     * @return GridGallery_Galleries_Model_Settings
     */
    protected function createSettingsModel()
    {
        $model = new GridGallery_Galleries_Model_Settings();
        $model->setDebugEnabled($this->debugEnabled);

        if ($this->logger && method_exists($model, 'setLogger')) {
            $model->setLogger($this->logger);
        }

        return $model;
    }

    /**
     * Extends the $preset object with the settings.
     * @param  object $preset
     * @throws UnexpectedValueException If the preset is not object.
     * @return object
     */
    protected function extend($preset)
    {
        if (!is_object($preset)) {
            throw new UnexpectedValueException(
                sprintf(
                    '$preset must be the object, %s given.',
                    gettype($preset)
                )
            );
        }

        $preset->settings = $this->getSettingsModel()
            ->getById((int)$preset->settings_id);

        return $preset;
    }

    /**
     * Returns the preset by custom fields and values.
     * @param string $field Field name.
     * @param mixed $value Field value.
     * @return object|null
     */
    protected function getBy($field, $value)
    {
        $query = $this->getQueryBuilder()->select('*')
            ->from($this->table)
            ->where($field, '=', $value);

        if (null !== $preset = $this->db->get_row($query->build())) {
            $preset = $this->extend($preset);
        }

        return $preset;
    }

	/**
	 * Returns an array of the names of user categories presets.
	 * @return array
	 */
	public function getCatsPresetsNames() {
		$presetsNames = array();
		$dbPresetOpt = get_option('customCatsPresets');
		$i = 1;
		foreach($dbPresetOpt as $dbPresetName) {
			$presetsNames[$i] = $dbPresetName['preset']['name'];
			$i++;
		}

		return $presetsNames;
	}

	/**
	 * Returns an array of the names of user pages presets.
	 * @return array
	 */
	public function getPagesPresetsNames() {
		$presetsNames = array();
		$dbPresetOpt = get_option('customPagesPresets');
		$i = 1;
		foreach($dbPresetOpt as $dbPresetName) {
			$presetsNames[$i] = $dbPresetName['preset']['name'];
			$i++;
		}

		return $presetsNames;
	}
}
