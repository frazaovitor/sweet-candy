<?php

/**
 * Class GridGallery_Galleries_Model_Resources
 * The Resources model implement logic to work with the Galleries Resources.
 * Please, don't use this model to work with the galleries table directly.
 * You can use Galleries model for that.
 *
 * @package GridGallery\Galleries\Model
 * @author Artur Kovalevsky
 */
class GridGallery_Galleries_Model_Resources extends GridGallery_Core_BaseModel
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $excluded;

    /**
     * Constructor
     *
     * @param bool $debugEnabled
     * @param null $logger
     */
    public function __construct($debugEnabled = false, $logger = null)
    {
        parent::__construct();

        $this->debugEnabled = $debugEnabled;
        $this->logger = $logger;
        $this->table = $this->db->prefix . 'gg_galleries_resources';
        $this->excluded = $this->db->prefix . 'gg_galleries_excluded';
    }

    /**
     * Returns the resources for specified gallery
     *
     * @param int $galleryId The identifier of the gallery
     * @return array|null
     */
    public function getByGalleryId($galleryId)
    {
        $query = $this->getQueryBuilder()->select('resource_id', 'resource_type')
            ->from($this->table)
            ->where('gallery_id', '=', (int)$galleryId);

        return $this->db->get_results($query->build());
    }

    public function getExcludedByGalleryId($galleryId) {
        $query = $this->getQueryBuilder()->select('folder_id', 'photo_id')
            ->from($this->excluded)
            ->where('gallery_id', '=', (int)$galleryId);

        return $this->db->get_results($query->build());
    }

    /**
     * Attaches resources to the gallery by the gallery identifier
     *
     * @param int $galleryId
     * @param string $resourceType
     * @param int $resourceId
     * @param bool $setPosition true if need to set position of attach
     * @return bool TRUE on success, FALSE otherwise
     */
    public function attach($galleryId, $resourceType, $resourceId, $setPosition = false)
    {
        $query = $this->getQueryBuilder()->insertInto($this->table)
            ->fields('gallery_id', 'resource_type', 'resource_id')
            ->values((int)$galleryId, $resourceType, (int)$resourceId);

        if ($resourceType === 'folder') {
            // $this->unexclude($resourceId, $galleryId);
        }

        if (!$this->db->query($query->build())) {
            $this->lastError = $this->db->last_error;
            return false;
        }

        $this->insertId = $this->db->insert_id;

        if($setPosition){
            $position = new GridGallery_Photos_Model_Position();
            //get current postion in gallery( last pos + 1)
            $currPosition = $position->getCurrentPosition(GridGallery_Photos_Model_Position::SCOPE_GALLERY,$galleryId);

            $arr = array(
                'scope' => GridGallery_Photos_Model_Position::SCOPE_GALLERY,
                'scope_id' => (int)$galleryId,
                'position' => $currPosition,
                'photo_id' => $resourceId,
            );
            $position->updatePosition($arr);
        }

        if ($this->logger) {
            $this->logger->info('The {resource_type} (ID: {resource_id}) was successfully attached to the gallery {gallery_id} with ID {insert_id}', array(
                'resource_id' => $resourceId,
                'resource_type' => $resourceType,
                'gallery_id' => $galleryId,
                'insert_id' => $this->getInsertId(),
            ));
        }

        return true;
    }

    public function unexclude($folderId, $galleryId)
    {
        $query = $this->getQueryBuilder()
            ->deleteFrom($this->excluded)
            ->where('folder_id', '=', (int)$folderId)
            ->andWhere('gallery_id', '=', (int)$galleryId);

        $this->db->query($query->build());
    }

    public function getGalleriesWithFolder($folderId)
    {
        return $this->getGalleriesWith('folder', $folderId);
    }

    public function getGalleriesWithPhoto($photoId)
    {
        return $this->getGalleriesWith('photo', $photoId);
    }

    public function getGalleriesWith($resourceType, $resourceId)
    {
        $query = $this->getQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->where('resource_type', '=', $resourceType)
            ->andWhere('resource_id', '=', (int)$resourceId);

        if (!$rows = $this->db->get_results($query->build())) {
            return null;
        }

        return $rows;
    }

    /**
     * Attaches resources to the gallery from the HTTP request
     *
     * @param Rsc_Http_Request $request The HTTP request
     * @param Rsc_Lang $lang The instance of the language class
     *
     * @return mixed
     * @throws GridGallery_Galleries_Exception_AttachException If not enough input data
     */
    public function attachFromRequest(Rsc_Http_Request $request, Rsc_Lang $lang)
    {
        if (!$resources = $request->post->get('resources')) {

            if ($this->logger) {
                $this->logger->error('The POST request is not contain \'resources\' value in {method}', array(
                    'method' => __METHOD__,
                ));
            }

            throw new GridGallery_Galleries_Exception_AttachException(
                $lang->translate('Resources are does not exists')
            );
        }

        if (!$galleryId = $request->post->get('gallery_id')) {

            if ($this->logger) {
                $this->logger->error('The POST request is not contain \'gallery_id\' value in {method}', array(
                    'method' => __METHOD__,
                ));
            }

            throw new GridGallery_Galleries_Exception_AttachException(
                $lang->translate('The identifier of the Gallery is not specified')
            );
        }
        //set to new photos default position in gallery
        $position = new GridGallery_Photos_Model_Position();
        //get current postion in gallery( last pos + 1)
        $currPosition = $position->getCurrentPosition(GridGallery_Photos_Model_Position::SCOPE_GALLERY,$galleryId);

        foreach ($resources as $resource) {
            if (!$this->attach((int)$galleryId, $resource['type'], (int)$resource['id'])) {
                if ($this->logger) {
                    $this->logger->error('Resource {id} ({type}) was not attached to the gallery {gallery_id}: {error}', array(
                        'id' => $resource['id'],
                        'type' => $resource['type'],
                        'gallery_id' => $galleryId,
                        'error' => $this->getLastError(),
                    ));
                }
            }else{
                //updating a position for new photos in gallery
                $arr = array(
                    'scope' => GridGallery_Photos_Model_Position::SCOPE_GALLERY,
                    'scope_id' => (int)$galleryId,
                    'position' => $currPosition++,
                    'photo_id' => (int)$resource['id'],
                );
                $position->updatePosition($arr);
            }
        }

        return $galleryId;
    }

    public function deleteFromRequest(Rsc_Http_Request $request)
    {
        $galleryId = $request->post->get('gallery_id');
        $resources = $request->post->get('ids');

        if (!$galleryId) {
            throw new UnexpectedValueException(
                'The identifier of the gallery is invalid.'
            );
        }

        if (!is_array($resources) || count($resources) < 1) {
            throw new UnexpectedValueException('The resources are invalid.');
        }

        $galleryId = (int)$galleryId;

        $this->remove($galleryId, $resources);
    }

    protected function remove($galleryId, array $identifiers)
    {
        $folders = array();
        $photos = null;

        foreach ($identifiers as $resourceId) {
            if ($this->photoExists($galleryId, $resourceId)) {
                $this->removePhotoFromGallery($galleryId, $resourceId);
            } else {
                if (empty($folders)) {
                    $folders = $this->getGalleryFolders($galleryId);
                }

                if (null === $photos) {
                    $photos = new GridGallery_Photos_Model_Photos(
                        $this->debugEnabled
                    );
                }

                foreach ($folders as $folder) {
                    $folderId = $folder->resource_id;
                    $folderPhotos = $photos->getPhotosByFolderId($folderId);

                    if ($folderPhotos) {
                        foreach ($folderPhotos as $folderPhoto) {
                            if ($folderPhoto->id === $resourceId) {
                                $this->exclude($galleryId, $folderId, $resourceId);
                            }
                        }
                    }
                }
            }
        }
    }

    protected function photoExists($galleryId, $resourceId)
    {
        $query = $this->getQueryBuilder()->select('*')
            ->from($this->table)
            ->where('gallery_id', '=', (int)$galleryId)
            ->andWhere('resource_type', '=', 'photo')
            ->andWhere('resource_id', '=', (int)$resourceId);

        return (null !== $this->db->get_row($query->build()));
    }

    protected function removePhotoFromGallery($galleryId, $photoId)
    {
        $query = $this->getQueryBuilder()->deleteFrom($this->table)
            ->where('gallery_id', '=', (int)$galleryId)
            ->andWhere('resource_type', '=', 'photo')
            ->andWhere('resource_id', '=', (int)$photoId);

        return $this->db->query($query->build());
    }

    protected function exclude($galleryId, $folderId, $photoId)
    {
        $query = $this->getQueryBuilder()->insertInto($this->excluded)
            ->fields('folder_id', 'photo_id', 'gallery_id')
            ->values((int)$folderId, (int)$photoId, (int)$galleryId);

        $this->db->query($query->build());
    }

    protected function getGalleryFolders($galleryId)
    {
        $query = $this->getQueryBuilder()->select('*')
            ->from($this->table)
            ->where('gallery_id', '=', (int)$galleryId)
            ->andWhere('resource_type', '=', 'folder');

        return $this->db->get_results($query->build());
    }

    /**
     * Deletes all resources attached to the specified gallery
     *
     * @param int $galleryId The identifier of the gallery
     * @return bool TRUE on success, FALSE otherwise
     */
    public function deleteByGalleryId($galleryId)
    {
        return $this->deleteBy('gallery_id', (int)$galleryId);
    }

    /**
     * Deletes the resource by resource id.
     * @param int $resourceId
     * @return bool
     */
    public function deleteByResourceId($resourceId)
    {
        return $this->deleteBy('resource_id', (int)$resourceId);
    }

    /**
     * Deletes the resource by specified field and value.
     * @param string $field The name of the field.
     * @param mixed $identifier The field value.
     * @return bool
     */
    public function deleteBy($field, $identifier)
    {
        $query = $this->getQueryBuilder()->deleteFrom($this->table)
            ->where($field, '=', $identifier);

        if (!$this->db->query($query->build())) {
            return false;
        }

        return true;
    }

    public function deletePhotoById($id)
    {
        $query = $this->getQueryBuilder()->deleteFrom($this->table)
            ->where('resource_id', '=', (int)$id)
            ->andWhere('resource_type', '=', 'photo');

        if (!$this->db->query($query->build())) {
            return false;
        }

        return true;
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

    // Deletes attached resources this is handler for delete_attachment action
    public function deleteAttachmentResources($attachmentId)
    {
        $query = "DELETE FROM {prefix}gg_galleries_resources
        WHERE resource_id IN 
            (SELECT id FROM {prefix}gg_photos WHERE attachment_id = %d)";
        $query = str_replace('{prefix}', $this->db->prefix, $query);
        $this->db->query($this->db->prepare($query, $attachmentId));
    }

	public function extendGalleryPhotoCount(&$galleryList) {
		$query = $this->getQueryBuilder()
			->select(array('gallery_id', 'count(gallery_id) as count'))
			->from($this->table)
			->where('resource_type', '=', 'photo')
			->groupBy('gallery_id');

		$photoCountList = $this->db->get_results($query->build(), OBJECT_K);

		if(count($galleryList) > 0) {
			foreach($galleryList as $key => $gallObj) {
				if(isset($photoCountList[$gallObj->id])) {
					$gallObj->photo_count = $photoCountList[$gallObj->id]->count;
				} else {
					$gallObj->photo_count = 0;
				}
			}
			return true;
		}
		return false;
	}

    public function cloneByGalleryId($oldGalleryId, $newGalleryId) {
        $oldResources = $this->getByGalleryId($oldGalleryId);
        $oldExcluded = $this->getExcludedByGalleryId($oldGalleryId);

        if(count($oldResources)) {
            $query = $this->getQueryBuilder()->insertInto($this->table)
                ->fields('gallery_id', 'resource_type', 'resource_id');
            foreach($oldResources as $resValue) {
                $query = $query->values($newGalleryId, $resValue->resource_type, $resValue->resource_id);
            }
            $this->db->query($query);
        }

        if(count($oldExcluded)) {
            $queryExl = $this->getQueryBuilder()->insertInto($this->excluded)
                ->fields('gallery_id', 'folder_id', 'photo_id');
            foreach($oldExcluded as $exlValue) {
                $queryExl = $queryExl->values($newGalleryId, $exlValue->folder_id, $exlValue->photo_id);
            }
            $this->db->query($queryExl);
        }
        return true;
    }

    public function getPhotoIdsByGalleryId($galleryId, $resourceType = 'photo') {
        $resCount = 0;

        $query = $this->getQueryBuilder()->select('resource_id')
            ->from($this->table)
            ->where('gallery_id', '=', (int) $galleryId)
            ->andWhere('resource_type', '=', $resourceType);

        $dbRes = $this->db->get_results($query->build(), ARRAY_A);
        return $dbRes;
    }
}
