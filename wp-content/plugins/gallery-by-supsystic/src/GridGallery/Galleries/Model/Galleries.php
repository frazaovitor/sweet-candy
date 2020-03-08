<?php

/**
 * Class GridGallery_Galleries_Model_Galleries
 * Provides the logic to work with the galleries
 *
 * @package GridGallery\Galleries\Model
 * @author Artur Kovalevsky
 */
class GridGallery_Galleries_Model_Galleries extends GridGallery_Core_BaseModel
{

    /**
     * @var string
     */
    protected $table;

    /**
     * Constructor
     * @param bool $debugEnabled
     */
    public function __construct($debugEnabled = false)
    {
        parent::__construct($debugEnabled);

        $this->debugEnabled = (bool)$debugEnabled;
        $this->table = $this->db->prefix . 'gg_galleries';
    }

    /**
     * Returns the data of the gallery by the identifier
     *
     * @param int $id The identifier of the gallery
     * @return object|null
     */
    public function getById($attributes)
    {
        $galleryId = is_numeric($attributes) ? $attributes : $attributes['id'];
        $attrArray = is_array($attributes) ? $attributes : array();
        $query = $this->getQueryBuilder()->select('*')
            ->from($this->table)
            ->where('id', '=', (int)$galleryId);

        if ($gallery = $this->db->get_row($query->build())) {
	        $gallery = $this->extend($gallery, $attrArray);
        }
		$gallery = $this->environment->getDispatcher()->applyFilters('after_gallery_get', $gallery);

        return $gallery;
    }

    /**
     * Returns the array of the galleries
     *
     * @return array|null
     */
    public function getAll()
    {
        if ($galleries = $this->getList()) {
            foreach ($galleries as $index => $gallery) {
                $galleries[$index] = $this->extend($gallery);
            }
        }

        return $galleries;
    }

    /**
     * Returns the array of the galleries with thumbnails
     *
     * @return array|null
     */
    public function getListWithThumbnails()
    {

        $query = array(
            'SELECT {prefix}gg_galleries.*, {prefix}gg_photos.attachment_id, r.total, {prefix}gg_settings_sets.data as settings, {prefix}gg_photos.link_default',
                'FROM {prefix}gg_galleries',
                'LEFT JOIN',
                '(SELECT count(resource_id) as total, resource_id, gallery_id',
                    'FROM {prefix}gg_galleries_resources GROUP BY gallery_id) as r',
                'ON {prefix}gg_galleries.id = r.gallery_id',
                'LEFT JOIN {prefix}gg_photos ON r.resource_id = {prefix}gg_photos.id',
                'LEFT JOIN {prefix}gg_settings_sets ON {prefix}gg_galleries.id = {prefix}gg_settings_sets.gallery_id',
                'ORDER BY {prefix}gg_galleries.id DESC'
            );
        $query = implode(' ', $query);
        $query = str_replace('{prefix}', $this->db->prefix, $query);
        return $this->db->get_results($query);
    }

    /**
     * Returns the array of the NOT extended galleries
     *
     * @return null|array
     */
    public function getList()
    {
        $query = $this->getQueryBuilder()->select('*')
            ->from($this->table)
            ->orderBy('id')
            ->order('DESC');

        return $this->db->get_results($query->build());
    }

    /**
     * Adds the empty gallery to the database
     * @param string $title
     * @return bool TRUE on success, FALSE otherwise
     */
    public function add($title)
    {
        $query = $this->getQueryBuilder()->insertInto($this->table)
            ->fields('title')
            ->values($title);

        if (!$this->db->query($query->build())) {
            return false;
        }

        $this->insertId = $this->db->insert_id;

        do_action(apply_filters('gg_hooks_prefix', 'gallery_created'), $this->db->insert_id);

        return true;
    }

    /**
     * Creates the new gallery from the HTTP request
     * @param Rsc_Http_Request $request The HTTP request
     * @param Rsc_Lang $lang The instance of the language class
     * @param Rsc_Config $config
     * @return bool TRUE on success, FALSE otherwise
     */
    public function createFromRequest(Rsc_Http_Request $request, Rsc_Lang $lang, Rsc_Config $config)
    {
        $title = $request->post->get('title');
        $unnamed = (!$title || sizeof($title) == 0);

        if($unnamed) {
            $title = $lang->translate('Unnamed gallery');
        }

        $title = htmlspecialchars($request->post->get('title'), ENT_QUOTES);

        $res = $this->add($title);

        if ($res) {
            $id = $this->db->insert_id;

            if($unnamed) {
                $this->rename($id, $lang->translate('Gallery ').$id);
            }

            $config->load('@galleries/presets.php');
            $presets = $config->get('gallery_presets');

            $data = $presets[$request->post->get('preset', 1)];

            $settings = new GridGallery_Galleries_Model_Settings();
            $settings->save($id, unserialize($data));

            return true;
        }

        return false;
    }

    /**
     * Renames the gallery by the specified identifier
     *
     * @param int $galleryId The identifier of the gallery
     * @param string $title The new title of the gallery
     * @return bool TRUE on success, FALSE otherwise
     */
    public function rename($galleryId, $title)
    {
        $query = $this->getQueryBuilder()->update($this->table)
            ->fields('title')
            ->values(htmlspecialchars($title, ENT_QUOTES, get_bloginfo('charset')))
            ->where('id', '=', (int)$galleryId);

        if (!$this->db->query($query->build())) {

            if ($this->logger) {
                $this->logger->error('Failed to execute query: ({query}) in method {method}', array(
                    'query' => $query,
                    'method' => __METHOD__,
                ));
            }

            return false;
        }

        return true;
    }

    /**
     * Renames the gallery from the HTTP request
     *
     * @param Rsc_Http_Request $request An instance of the HTTP request
     * @param Rsc_Lang $lang An instance of the translation class
     * @throws RuntimeException When rename query return FALSE
     * @throws InvalidArgumentException If at least one argument is invalid
     */
    public function renameFromRequest(Rsc_Http_Request $request, Rsc_Lang $lang)
    {
        $galleryId = $request->post->get('gallery_id');
        $title = $request->post->get('title');

        if (!is_numeric($galleryId)) {
            throw new InvalidArgumentException($lang->translate('The identifier of the gallery is invalid'));
        }

        if (empty($title)) {
            throw new InvalidArgumentException($lang->translate('Title is empty'));
        }

        if (!$this->rename($galleryId, $title)) {
            throw new RuntimeException(
                $lang->translate('Failed to rename the gallery')
            );
        }
    }

    /**
     * Deletes gallery from the database from the HTTP request
     *
     * @param Rsc_Http_Request $request An instance of the HTTP request
     * @param Rsc_Lang $lang An instance of the translation class
     * @param string $hooksPrefix The prefix for the plugin hooks
     * @throws RuntimeException
     * @throws UnexpectedValueException
     */
    public function deleteFromRequest(Rsc_Http_Request $request, Rsc_Lang $lang, $hooksPrefix = null)
    {
        $galleryId = $request->query->get('gallery_id');

        if (!is_numeric($galleryId)) {
            throw new UnexpectedValueException($lang->translate('Invalid gallery identifier specified'));
        }

        if (!$this->delete($galleryId, $hooksPrefix)) {
            throw new RuntimeException($lang->translate('Failed to delete the gallery'));
        }
    }

    /**
     * Deletes the gallery by the identifier
     *
     * @param int $galleryId The identifier of the gallery
     * @param string $hooksPrefix The prefix for the plugin hooks
     * @return bool TRUE on success, FALSE otherwise
     */
    public function delete($galleryId, $hooksPrefix = null)
    {
        $query = $this->getQueryBuilder()->deleteFrom($this->table)
            ->where('id', '=', (int)$galleryId);

        if (!$this->db->query($query->build())) {

            if ($this->logger) {
                $this->logger->error('Failed to execute query ({query}) in method {method}', array(
                    'query' => $query,
                    'method' => __METHOD__,
                ));
            }

            return false;
        }

        do_action($hooksPrefix . 'gallery_delete', $galleryId);

        return true;
    }

    /**
     * Sets the settings for the gallery
     *
     * @param int $galleryId
     * @param int $settingsId
     * @return bool TRUE on success, FALSE otherwise
     */
    public function setSettings($galleryId, $settingsId)
    {
        $query = $this->getQueryBuilder()->update($this->table)
            ->fields('settings_id')
            ->values((int)$settingsId)
            ->where('id', '=', (int)$galleryId);

        if (!$this->db->query($query->build())) {
            return false;
        }

        return true;
    }

    /**
     * Sets the default settings for the gallery
     *
     * @param int $galleryId
     * @return bool TRUE on success, FALSE otherwise
     */
    public function setDefaultSettings($galleryId)
    {
        return true;
    }

    /**
     * Extends default gallery select
     *
     * @param object $gallery The result of the SELECT
     * @return mixed
     */
    protected function extend($gallery, $attributes = array())
    {
        if (!is_object($gallery)) {
            if ($this->debugEnabled) {
                wp_die(sprintf('The $gallery variable must be type of object, %s given', gettype($gallery)));
            }

            return $gallery;
        }

        $models = array();
        $models['settings'] = new GridGallery_Galleries_Model_Settings($this->debugEnabled);
        $settings = $models['settings']->getByGalleryId($gallery->id);

        if (is_object($settings)) {
            $gallery->settings_id = $settings->id;
            $gallery->settings = $settings->data;
        }

        if(isset($attributes) && isset($attributes['membershipModel'])) {
            $memberShipModel = $attributes['membershipModel'];
            foreach($attributes['image-list'] as $oneImage) {
                $gallery->photos[] = $memberShipModel->getGalleryAttachmenEmuledImage($oneImage);
            }
        } else {
            $resources = new GridGallery_Galleries_Model_Resources($this->debugEnabled);
            $resourcesData = $resources->getByGalleryId($gallery->id);

            if (!$resourcesData) {
                return $gallery;
            }

            $gallery->photos = array();

            $models['photos'] = new GridGallery_Photos_Model_Photos($this->debugEnabled);
            $models['folders'] = new GridGallery_Photos_Model_Folders($this->debugEnabled);

            /*foreach ($resourcesData as $data) {
				switch ($data->resource_type) {
					case 'folder':
						if ($photos = $models['folders']->getPhotosById($data->resource_id)) {
							foreach ($photos as $photo) {
								if (!$this->isExcluded($gallery->id, $data->resource_id, $photo->id)) {
									$gallery->photos[] = $photo;
								}
							}
						}
						break;

					case 'photo':
						$gallery->photos[] = $models['photos']->getById($data->resource_id);
						break;
				}
			}*/
            $gallery->photos = $models['photos']->getPhotos($resourcesData);
        }

        return $gallery;
    }

    public function isExcluded($galleryId, $folderId, $photoId)
    {
        $table = $this->db->prefix . 'gg_galleries_excluded';

        $query = $this->getQueryBuilder()->select('*')
            ->from($table)
            ->where('gallery_id', '=', (int)$galleryId)
            ->andWhere('folder_id', '=', (int)$folderId)
            ->andWhere('photo_id', '=', (int)$photoId);

        return (null !== $this->db->get_row($query->build()));
    }

    /**
     * Sets a logger instance on the object
     *
     * @param Rsc_Logger_Interface $logger
     * @return null
     */
    public function setLogger(Rsc_Logger_Interface $logger)
    {
        $this->logger = $logger;
    }

	public function getGalleryTitle($id) {
		$query = $this->getQueryBuilder()->select('title')
			->from($this->table)
			->where('id', '=', (int)$id);

		$res = $this->db->get_row($query->build(), ARRAY_A);
		if(count($res) && !empty($res['title'])) {
			return $res['title'];
		}
		return null;
	}

	public function cloneGallery($galleryId, $cloneType, $parameters) {
		$language = $parameters['environment']->getLang();
		$resourceModel = $parameters['resources'];
		$settingsModel = $parameters['settings'];
		$positionModel = $parameters['position'];
		$cdnModel = $parameters['cdn'];
		$membershipModel = $parameters['membership'];

		$hasError = false;
		$message = '';
		$galleryId = (int) $galleryId;
		if(!$galleryId) {
			$hasError = true;
			$message = $language->translate('Source gallery incorrect id');
		}
		if($cloneType != 1 && $cloneType != 2) {
			$hasError = true;
			$message = $language->translate('Clone type parameter is incorrect');
		}
		// copy all tables
		// gg_galleries
		if(!$hasError) {
			$ggTitle = $this->getGalleryTitle($galleryId);
			if($ggTitle) {
				$ggTitle = $language->translate('Cloned ') . $ggTitle;
			} else {
				$ggTitle = $language->translate('Cloned gallery ' . $galleryId);
			}
			if(!$this->add($ggTitle)) {
				$message = $language->translate('Can\'t create new gallery!');
				$hasError = true;
			}
		}

		if(!$hasError && $this->insertId) {
			$newGalleryId = $this->insertId;
			if($cloneType != 2) {
				// gg_galleries_excluded
				// gg_galleries_resources
				if(!$resourceModel->cloneByGalleryId($galleryId, $newGalleryId)) {
					$message = $language->translate('Can\'t create resources for gallery!');
					$hasError = true;
				}
				// gg_photos_pos
				if(!$hasError && !$positionModel->cloneByScopeId($galleryId, $newGalleryId)) {
					$message = $language->translate('Can\'t create image position for gallery!');
					$hasError = true;
				}
			}
			// gg_settings_sets
			if(!$hasError && !$settingsModel->cloneByGalleryId($galleryId, $newGalleryId)) {
				$message = $language->translate('Can\'t create settings for gallery!');
				$hasError = true;
			}
			// gg_membership_presets
			if(!$hasError && !$membershipModel->cloneByGalleryId($galleryId, $newGalleryId)) {
				$message = $language->translate('Can\'t create membership params for gallery!');
				$hasError = true;
			}
		}

		return array(
			'message' => $message,
			'isError' => $hasError,
			'newGalleryId' => $newGalleryId,
		);
    }
}
