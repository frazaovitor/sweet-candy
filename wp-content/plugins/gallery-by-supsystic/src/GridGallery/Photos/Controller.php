<?php

/**
 * Class GridGallery_Photos_Controller
 *
 * @package GridGallery\Photos
 */
class GridGallery_Photos_Controller extends GridGallery_Core_BaseController
{

    const STD_VIEW = 'list'; // accepts 'list' or 'block'.

    public function requireNonces() {
        return array(
            'addAction',
            'addFolderAction',
            'deleteAction',
            'moveAction',
            'updateTitleAction',
            'updateAttachmentAction',
            'updatePositionAction'
        );
    }
    /**
     * {@inheritdoc}
     */
    protected function getModelAliases()
    {
        return array(
            'resources' => 'GridGallery_Galleries_Model_Resources',
            'photos' => 'GridGallery_Photos_Model_Photos',
            'folders' => 'GridGallery_Photos_Model_Folders',
            'position' => 'GridGallery_Photos_Model_Position',
        );
    }

    /**
     * Index Action
     * Shows the list of the all photos
     */
    public function indexAction(Rsc_Http_Request $request)
    {
        $stats = $this->getEnvironment()->getModule('stats');
        $stats->save('Images.tab');

        if ('grid-gallery-images' === $request->query->get('page')) {
            $redirectUrl = $this->generateUrl('photos');

            return $this->redirect($redirectUrl);
        }

        $folders = $this->getModel('folders');
        $photos = $this->getModel('photos');
        $position = $this->getModel('position');

        $images = array_map(
            array($position, 'setPosition'),
            $photos->getAllWithoutFolders()
        );

        return $this->response(
            '@photos/index.twig',
            array(
                'entities' => array(
                    'images' => $position->sort($images),
                    'folders' => $folders->getAll()
                ),
                'view_type' => $request->query->get('view', self::STD_VIEW),
                'ajax_url' => admin_url('admin-ajax.php'),
            )
        );
    }

    /**
     * View Action
     * Shows the photos in the selected album
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function viewAction(Rsc_Http_Request $request)
    {
        if (!$request->query->has('folder_id')) {
            $this->redirect(
                $this->getEnvironment()->generateUrl('photos', 'index')
            );
        }

        $stats = $this->getEnvironment()->getModule('stats');
        $stats->save('folders.view');

        $folderId = (int)$request->query->get('folder_id');

        $folders = $this->getModel('folders');

        if (!$folder = $folders->getById($folderId)) {
            $this->redirect(
                $this->getEnvironment()->generateUrl('photos', 'index')
            );
        }

        $position = $this->getModel('position');

        foreach ($folder->photos as $index => $row) {
            $folder->photos[$index] = $position->setPosition(
                $row,
                'folder',
                $folderId
            );
        }

        $folder->photos = $position->sort($folder->photos);

        return $this->response(
            '@photos/view.twig',
            array(
                'folder' => $folder,
                'ajax_url' => admin_url('admin-ajax.php'),
                'view_type' => $request->query->get('view', self::STD_VIEW),
            )
        );
    }

	/**
	 * Extract for use in Pro version
	 */
	protected function addPhotoResForAddAction($_photos, $_attachment, $_request) {
		return $_photos->add($_attachment->ID, $_request->post->get('folder_id', 0), array());
	}

    /**
     * Add Action
     * Adds new photos to the database
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function addAction(Rsc_Http_Request $request)
    {
        $env = $this->getEnvironment();

		$photos = $this->getModel('photos');

        if ($env->getConfig()->isEnvironment(
            Rsc_Environment::ENV_DEVELOPMENT
        )
        ) {
            $photos->setDebugEnabled(true);
        }

        $attachment = get_post($request->post->get('attachment_id'));
        $viewType = $request->post->get('view_type');

        $stats = $this->getEnvironment()->getModule('stats');
        $stats->save('photos.add');

        $this->getModule('galleries')->cleanCache($request->post->get('galleryId'));

		if (!$this->addPhotoResForAddAction($photos, $attachment, $request)) {
            $response = array(
                'error' => true,
                'photo' => null,
                'message' => sprintf(
                    $env->translate('Unable to save chosen photo %s: %s'),
                    $attachment->post_title,
                    $photos->getLastError()
                ),
            );
        } else {
            // $photo = $env->getTwig()->render(
            //     sprintf('@ui/%s/image.twig', $viewType ? $viewType : 'block'),
            //     array('image' => $photos->getByAttachmentId($attachment->ID))
            // );

            $response = array(
                'error' => false,
                // 'photo' => $photo,
                'message' => sprintf(
                    $env->translate(
                        'Photo %s was successfully imported to the Grid Gallery'
                    ),
                    $attachment->post_title
                ),
				'link' => $this->generateUrl(
					'galleries',
					'view',
					array('gallery_id' => $request->post->get('galleryId'))
				),
            );
        }

        if($request->post->get('attachType') && $request->post->get('galleryId')) {
            $this->getModel('resources')->attach($request->post->get('galleryId'), 'photo', $photos->getByAttachmentId($attachment->ID)->id,true);
        }

		$imageParams = array(
			'gallery_id' => $request->post->get('galleryId'),
			'attachment' => $attachment,
		);
		do_action('sgg_add_new_image_to_gallery', $imageParams);

        return $this->response(Rsc_Http_Response::AJAX, $response);
    }

    /**
     * Add Folder Action
     * Adds the new folder
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function addFolderAction(Rsc_Http_Request $request)
    {
        $env = $this->getEnvironment();
        $folders = new GridGallery_Photos_Model_Folders();

        $stats = $this->getEnvironment()->getModule('stats');
        $stats->save('folders.add');

        if ($env->getConfig()->isEnvironment(
            Rsc_Environment::ENV_DEVELOPMENT
        )
        ) {
            $folders->setDebugEnabled(true);
        }

        $folderName = $request->post->get('folder_name');
        $viewType = $request->post->get('view_type');

        if (!$folders->add(
            ($folderName) ? $folderName : $env->translate('New Folder')
        )
        ) {
            $response = array(
                'error' => true,
                'folder' => null,
            );
        } else {
            $folder = $env->getTwig()->render(
                sprintf('@ui/%s/folder.twig', $viewType ? $viewType : 'block'),
                array('folder' => $folders->getById($folders->getInsertId()))
            );

            $response = array(
                'error' => false,
                'folder' => $folder,
                'id' => $folders->getInsertId(),
            );
        }

        return $this->response('ajax', $response);
    }

    /**
     * Delete Action
     * Deletes the specified folders and photos
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function deleteAction(Rsc_Http_Request $request)
    {
        $env = $this->getEnvironment();
        $data = $request->post->get('data');
        $debug = $env->getConfig()->isEnvironment(
            Rsc_Environment::ENV_DEVELOPMENT
        );
        $photos = new GridGallery_Photos_Model_Photos($debug);
        $folders = new GridGallery_Photos_Model_Folders($debug);

        $stats = $this->getEnvironment()->getModule('stats');

        if (!$data) {
            return $this->response(
                'ajax',
                array(
                    'error' => true,
                )
            );
        }

        foreach ($data as $type => $identifies) {
            foreach ($identifies as $id) {
                if ($type === 'photo') {
                    $stats->save('photos.delete');
                    $photos->deleteById((int)$id);
                } else {
                    $stats->save('folders.delete');
                    $folders->deleteById((int)$id);
                }
            }
        }

        return $this->response(
            'ajax',
            array(
                'error' => false,
            )
        );
    }

    public function checkPhotoUsageAction(Rsc_Http_Request $request)
    {
        $photoId = $request->post->get('photo_id');

        $photos = $this->getModel('photos');
        $photo = $photos->getById($photoId);

        $resources = $this->getModel('resources');

        if ($photo->folder_id > 0) {
            $galleries = $resources->getGalleriesWithFolder($photo->folder_id);
        } else {
            $galleries = $resources->getGalleriesWithPhoto($photo->id);
        }

        return $this->response(Rsc_Http_Response::AJAX, array(
            'count' => count($galleries),
        ));
    }

    public function rotatePhotoAction(Rsc_Http_Request $request)
    {
        $env = $this->getEnvironment();
        $ids = $request->post->get('ids');
        $rotateType = $request->post->get('rotateType');
        $rotated = 0;
        if(isset($ids) && sizeof($ids) > 0) {
            $photos = $this->getModel('photos');

            foreach($ids as $i => $photoId) {
                $photo = $photos->getById($photoId);
                $attachment = $photo->attachment;
                if($photos->rotateAttachment($attachment, $rotateType)) {
                    $rotated++; 
                }
            }
        }
        $this->getModule('galleries')->cleanCache($request->post->get('gallery_id'));
        return $this->response(Rsc_Http_Response::AJAX, array('message' => sprintf($env->translate('There are %d photos successfully rotated'), $rotated)));
    }

    /**
     * Move Action
     * Moves photos to the folders
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function moveAction(Rsc_Http_Request $request)
    {
        $photos = new GridGallery_Photos_Model_Photos();
        $error = true;

        if ($this->getEnvironment()->getConfig()->isEnvironment(
            Rsc_Environment::ENV_DEVELOPMENT
        )
        ) {
            $photos->setDebugEnabled(true);
        }

        $photoId = $request->post->get('photo_id');
        $folderId = $request->post->get('folder_id');

        if ($photos->toFolder($photoId, $folderId)) {
            $error = false;
        }

        return $this->response(
            'ajax',
            array(
                'error' => $error,
            )
        );
    }

    /**
     * Render Action
     * Renders the photos from the folder
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function renderAction(Rsc_Http_Request $request)
    {
        $photos = $request->post->get('photos');

        if (!is_array($photos)) {
            return $this->response(
                'ajax',
                array(
                    'error' => true,
                    'photos' => null,
                )
            );
        }

        $renders = array();

        foreach ($photos as $photo) {
            $renders[] = $this->getEnvironment()->getTwig()->render(
                '@photos/includes/photo.twig', array('photo' => $photo)
            );
        }

        return $this->response(
            'ajax',
            array(
                'error' => false,
                'photos' => $renders,
            )
        );
    }

    /**
     * Update Title Action
     * Updates the title of the folder
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function updateTitleAction(Rsc_Http_Request $request)
    {
        $env = $this->getEnvironment();
        $folders = new GridGallery_Photos_Model_Folders();
        $title = trim($request->post->get('folder_name'));
        $folderId = $request->post->get('folder_id');

        if (empty($title)) {
            return $this->response(
                'ajax',
                array(
                    'error' => true,
                    'message' => $env->translate('The title can\'t be empty'),
                )
            );
        }

        if ($folders->updateTitle($folderId, $title)) {
            return $this->response(
                'ajax',
                array(
                    'error' => false,
                    'message' => $env->translate('Title successfully updated'),
                )
            );
        }

        return $this->response(
            'ajax',
            array(
                'error' => true,
                'message' => $env->translate(
                    'Unable to update the title. Try again later'
                ),
            )
        );
    }

    public function isEmptyAction()
    {
        $debugEnabled = $this->getEnvironment()->isDev();

        $isEmpty = true;
        $photos = new GridGallery_Photos_Model_Photos($debugEnabled);

        $photoCount = $photos->getAllImgCount();

        if ($photoCount > 0) {
            $isEmpty = false;
        }

        return $this->response(
            Rsc_Http_Response::AJAX,
            array(
                'isEmpty' => $isEmpty,
            )
        );
    }

    /**
     * Before update attachemnt
     * if attachment was updated then replace it and after save all information
     * to new attachment
     * @param Rsc_Http_Request $request
     */
	// old pro version compatibility - remove this method in future
	protected function beforeUpdateAttachment(Rsc_Http_Request $request){
		/** @var GridGallery_Photos_Model_Photos $photos */
		$photos = $this->getModel('photos');

		if($replaceAttachmentId = (int)$request->post->get('replace_attachment_id')){
			/**
			 * @var GridGallery_Galleries_Module $gallery
			 */
			$gallery = $this->getModule('galleries');
			$replacePost = get_post($replaceAttachmentId);
			$newAttachId = $gallery->media_sideload_image($replacePost->guid,0);
			$photos->updateAttachmentId($request->post->get('image_id'),$newAttachId);
			$request->post->set('attachment_id',$newAttachId);
			$request->post->set('replace_attachment_id',null);
		}
	}
    
    public function updateAttachmentAction(Rsc_Http_Request $request) {

        /** @var GridGallery_Photos_Model_Photos $photos */
		$photos = $this->getModel('photos');

        $alt = $request->post->get('alt');
        $attachmentId = $request->post->get('attachment_id');
		$replaceAttachmentId = (int)$request->post->get('replace_attachment_id');
		if($replaceAttachmentId) {
			$photos->updateAttachmentId($request->post->get('image_id'), $replaceAttachmentId);
			$attachmentId = $replaceAttachmentId;
		}
        $caption = $request->post->get('caption');
        $description = $request->post->get('description');
        $target = $request->post->get('target', '_self');
        $link = $request->post->get('link');
        $captionEffect = $request->post->get('captionEffect');
        $cropPosition = $request->post->get('cropPosition');

        if($link){
            $rel = trim(implode(' ', $request->post->get('rel', '')));
        } else {
            $rel = '';
        }

        $update = array();
        if(isset($alt)) $update['alt'] = (empty($alt) ? " " : $alt);
        if(isset($caption)) $update['caption'] = $caption;
        if(isset($description)) $update['description'] = $description;
        if(isset($captionEffect)) $update['captionEffect'] = $captionEffect;
        if(isset($cropPosition)) $update['cropPosition'] = $cropPosition;
        if(isset($link))
        {
            $update['link'] = $link;
            $update['target'] = $target;
            $update['rel'] = $rel;
        }
		$update = $this->getEnvironment()->getDispatcher()->applyFilters('before_update_photo_attachment', $update, $attachmentId);
		$photos->updateMetadata($attachmentId, $update);

        $this->getModule('galleries')->cleanCache($request->post->get('gallery_id'));

        return $this->response(Rsc_Http_Response::AJAX);
    }

    /**
     * Updates the position of the photo.
     * @param  Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function updatePositionAction(Rsc_Http_Request $request)
    {
        $response = $this->getErrorResponseData(
            $this->translate('Failed to update position.')
        );
        $data = $request->post->get('data');

        if ($this->getModel('position')->replacePosition($data)) {
            $response = $this->getSuccessResponseData(
                $this->translate('Position updated successfully!')
            );
        }
        $this->getModule('galleries')->cleanCache($data['scope_id']);

        return $this->response(Rsc_Http_Response::AJAX, $response);
    }
}
