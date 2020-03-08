<?php

/**
 * Class GridGallery_Galleries_Controller
 * The controller of the Galleries module.
 *
 * @package GridGallery\Galleries
 * @author  Artur Kovalevsky
 */
class GridGallery_Galleries_Controller extends GridGallery_Core_BaseController
{

    const STD_VIEW = 'list'; // list or block

    public function requireNonces() {
        return array(
            'createAction',
            'sideloadSaveAction',
            'attachAction',
            'chooseAction',
            'renameAction',
            'deleteAction',
            'deleteGroupAction',
            'deleteResourceAction',
            'addImagesAction',
            'saveSettingsAction',
            'saveCatsPresetAction',
            'savePagesPresetAction',
            'savePresetAction',
            'removePresetAction',
            'applyPresetAction',
            'sendUsageStat',
            'ajaxResizeImageAction',
            'saveSortByAction',
            'importSettingsAction',
			'cloneAction',
	        'createDefaultGallerySettingsAction',
	        'removeDefaultGallerySettingsAction',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelAliases()
    {
        return array(
            'socialSharing' => 'GridGallery_Galleries_Model_SocialSharing',
            'galleries' => 'GridGallery_Galleries_Model_Galleries',
            'resources' => 'GridGallery_Galleries_Model_Resources',
            'settings' => 'GridGallery_Galleries_Model_Settings',
            'preset' => 'GridGallery_Galleries_Model_Preset',
            'photos' => 'GridGallery_Photos_Model_Photos',
            'folders' => 'GridGallery_Photos_Model_Folders',
            'position' => 'GridGallery_Photos_Model_Position',
			'cdn' => 'GridGallery_Optimization_Model_Cdn',
			'imageOptimize' => 'GridGallery_Optimization_Model_ImageOptimize',
			'optimization' => 'GridGallery_Optimization_Model_Optimization',
			'membership' => 'GridGallery_Membership_Model_Membership',
			'pagination' => 'GridGallery_Galleries_Model_Pagination',
        );
    }

    /**
     * Index Action
     * Shows the list of the galleries
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function indexAction(Rsc_Http_Request $request)
    {
        $stats = $this->getEnvironment()->getModule('stats');
        $stats->save('Galleries.tab');

        /*if ('grid-gallery-new' === $request->query->get('page')) {
            $redirectUrl = $this->generateUrl('galleries') . '#add';

            return $this->redirect($redirectUrl);
        }*/

        $galleries = $this->getModel('galleries')->getListWithThumbnails();
        $settingsModel = $this->getModel('settings');

        foreach ($galleries as $gallery) {
            $gallery->settings = unserialize($gallery->settings);
        }

        $twig = $this->getEnvironment()->getTwig();
        $twig->addFunction(
            new Twig_SimpleFunction(
                'get_image_src',
                'wp_get_attachment_image_src'
            )
        );

        $settingsModel->PostThumb($galleries);

        return $this->response(
            '@galleries/index.twig',
            array(
                'galleries' => $galleries,
                'attachment_size' => 'gg_gallery_thumbnail',
            )
        );
    }

    /**
     * Preview Action
     */
    public function previewAction(Rsc_Http_Request $request)
    {
        $this->saveEvent('galleries.preview');
        $galleryId = $request->query->get('gallery_id');
        $shortcode = $this->getEnvironment()
            ->getConfig()
            ->get('shortcode_name', 'grid-gallery');

        try {
            $preview = new GridGallery_Galleries_Model_Preview();
            $postId = $preview->setPostContent(
                sprintf('[%s id="%s"]', $shortcode, $galleryId)
            );
        } catch (Exception $e) {
            return $this->response('error.twig', array(
                'message' => $e->getMessage(),
            ));
        }

        return $this->response('@galleries/preview.twig', array(
            'base_url' => get_bloginfo('wpurl'),
            'post_id' => $postId,
            'gallery_id' => $galleryId,
        ));
    }

    protected function getViewActionParams($request) {
		if (!$galleryId = $request->query->get('gallery_id')) {
			$this->redirect($this->generateUrl('galleries', 'index'));
		}

		if ( !$gallery = $this->getModel('galleries')->getById((int)$galleryId) ) {
			$this->redirect($this->generateUrl('galleries', 'index'));
		}

		$settings = $this->getModel('settings')->get($galleryId);
		if (!is_object($settings) || null === $settings->data) {
			$config = $this->getEnvironment()->getConfig();
			$config->load('@galleries/settings.php');

			$settings = new stdClass;

			$settings->id = null;
			$settings->data = unserialize($config->get('gallery_settings'));
		}

		$position = $this->getModel('position');

		if (is_object($gallery) && (property_exists($gallery, 'photos') && is_array($gallery->photos))) {
			foreach ($gallery->photos as $index => $row) {
				$gallery->photos[$index] = $position->setPosition(
					$row,
					'gallery',
					$gallery->id
				);
			}

			//ASC && DESC sort
			if(isset($settings->data['sort'])){
				$gallery->photos = $position->sort($gallery->photos, $settings->data['sort']);
			} else {
				$gallery->photos = $position->sort($gallery->photos);
			}

			$paginationModel = $this->getModel('pagination');
			$paginationModel->initParams(array(
				'totalCount' => count($gallery->photos),
			));
			$paginationSettings = $paginationModel->getAllLinks(110);

			// pagination
			if(count($gallery->photos)) {
				$imgPerPage = $paginationModel->getPerPageParam();
				$currentPage = $paginationModel->getPage();
				if($currentPage > 0) {
					$currentPage--;
				}
				if($imgPerPage == 'all') {
					$imgPerPage = null;
				}
				$fromImg = $currentPage*$imgPerPage;
				$gallery->photos = array_slice($gallery->photos, $fromImg, $imgPerPage, true);
				$this->getEnvironment()->getDispatcher()->dispatch('before_gallery_photos_edit', array($gallery->photos));
			}
		}
        $galleries = $this->getModel('galleries')->getList();
		return array(
			'gallery'   => $gallery,
			'viewType'  => $request->query->get('view', self::STD_VIEW),
			'ajaxUrl'   => admin_url('admin-ajax.php'),
			'settings'  => $settings->data,
            'galleries'  => $galleries,
			'paginationSettings' => isset($paginationSettings) ? $paginationSettings : null,
		);
	}

    protected function getSortActionParams($request) {
        if (!$galleryId = $request->query->get('gallery_id')) {
            $this->redirect($this->generateUrl('galleries', 'index'));
        }

        if ( !$gallery = $this->getModel('galleries')->getById((int)$galleryId) ) {
            $this->redirect($this->generateUrl('galleries', 'index'));
        }

        $settings = $this->getModel('settings')->get($galleryId);
        if (!is_object($settings) || null === $settings->data) {
            $config = $this->getEnvironment()->getConfig();
            $config->load('@galleries/settings.php');

            $settings = new stdClass;

            $settings->id = null;
            $settings->data = unserialize($config->get('gallery_settings'));
        }

        $position = $this->getModel('position');

        if (is_object($gallery) && (property_exists($gallery, 'photos') && is_array($gallery->photos))) {
            foreach ($gallery->photos as $index => $row) {
                $gallery->photos[$index] = $position->setPosition(
                    $row,
                    'gallery',
                    $gallery->id
                );
            }

            //ASC && DESC sort
            if(isset($settings->data['sort'])){
                $gallery->photos = $position->sort($gallery->photos, $settings->data['sort']);
            } else {
                $gallery->photos = $position->sort($gallery->photos);
            }
        }     
        return array(
            'gallery'   => $gallery,
            'ajaxUrl'   => admin_url('admin-ajax.php'),
            'settings'  => $settings->data,
        );
    }

    /**
     * View Action
     * Renders single gallery page
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function viewAction(Rsc_Http_Request $request) {

    	$params = $this->getViewActionParams($request);

        return $this->response(
            '@galleries/view.twig',
			$params
        );
    }

    /**
     * SortMode Action
     * Renders single gallery page
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function sortAction(Rsc_Http_Request $request) {

        $params = $this->getSortActionParams($request);

        return $this->response(
            '@galleries/sort.twig',
            $params
        );
    }

    /**
     * List Action
     * Returns the AJAX response with galleries list
     *
     * @return Rsc_Http_Response
     */
    public function listAction()
    {
        return $this->response(
            'ajax',
            array(
                'galleries' => $this->getModel('galleries')->getList(),
            )
        );
    }

    /**
     * Create Action
     * Creates the new gallery from the POST request
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function createAction(Rsc_Http_Request $request)
    {
        $galleries = $this->getModel('galleries');
        $language = $this->getEnvironment()->getLang();
        $logger = $this->getEnvironment()->getLogger();
        $config = $this->getEnvironment()->getConfig();

        $stats = $this->getEnvironment()->getModule('stats');
        $stats->save('galleries.create');

	    if(get_option('defaultgallerysettings')) {
		    $defaultSettingGalleryId = get_option('defaultgallerysettings');
	    } else {
		    $defaultSettingGalleryId = null;
	    }

        try {
            $galleries->createFromRequest($request, $language, $config);
            if($defaultSettingGalleryId){
	            $createdGalleryId = $galleries->getInsertId();
	            $settingsModel = $this->getModel('settings');
	            $settings = $settingsModel->get($defaultSettingGalleryId);
	            $defaultSettings = $settings->data;
	            $defaultSettings['defaultsettings'] = 0;
	            $settingsModel->save($createdGalleryId, $defaultSettings);
	            $this->getModule('galleries')->cleanCache($createdGalleryId, true);
            }
        } catch (Exception $e) {
            if ($logger) {
                $logger->error(
                    'Create a new gallery failed: {exception}',
                    array('exception' => $e)
                );
            }

            return $this->response(
                'ajax',
                $this->getErrorResponseData($e->getMessage())
            );
        }

        return $this->response(
            'ajax',
            $this->getSuccessResponseData(
                $this->translate('New gallery successfully created'),
                array(
                    'id' => $galleries->getInsertId(),
                    'url' => $this->generateUrl('galleries', 'settings', array(
                        'gallery_id' => $galleries->getInsertId(),
                    ))
                )
            )
        );
    }

    public function sideloadSaveAction(Rsc_Http_Request $request){
        $selectedImages = $request->post->get('urls');
        $photos = $this->getModel('photos');
        $attachID = array();

        foreach ($selectedImages as $image) {

            $id = $this->getModule('galleries')->media_sideload_image($image, 0);
            if($photos->add($id))
                $attachID[] = $photos->getInsertId();

        }
        return $this->response(Rsc_Http_Response::AJAX,
            array('msh' => 'Loaded', 'ids' => $attachID));
    }

    /**
     * Attach Action
     * Attaches resources to the specified gallery
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function attachAction(Rsc_Http_Request $request)
    {
        $logger = $this->getEnvironment()->getLogger();
        $lang = $this->getEnvironment()->getLang();

        try {

            $gid = $this->getModel('resources')->attachFromRequest($request, $lang);

        } catch (GridGallery_Galleries_Exception_AttachException $e) {

            if ($logger) {
                $logger->error(
                    'Failed to attach resources to gallery: {exception}',
                    array(
                        'exception' => $e,
                    )
                );
            }

            return $this->response(
                'ajax',
                $this->getErrorResponseData(
                    $e->getMessage()
                )
            );
        }

        

        $galleries = $this->getModel('galleries');
        $gallery = $galleries->getById($gid);

        //cleaning cache after attaching 
        $this->getModule('galleries')->cleanCache($gid);

        /*return $this->response(
            'ajax',
            $this->getSuccessResponseData(
                sprintf(
                    $lang->translate(
                        'The resources are successfully attached to the <a href="%s">%s</a>'
                    ),
                    $this->generateUrl(
                        'galleries',
                        'view',
                        array('gallery_id' => $gid)
                    ),
                    $gallery->title
                )
            )
        );*/

		return $this->response(
			'ajax',
			array(
				'message' => $this->translate('The resources are successfully attached to the '.$gallery->title),
				'galleryId' => (int)$gallery->id,
				'redirectUrl' => $this->getEnvironment()->generateUrl(
					'galleries',
					'view',
					array('gallery_id' => $gallery->id)
				)
			)
		);
    }

    public function chooseAction(Rsc_Http_Request $request)
    {
        $resourceId = $request->post->get('resources');
        $galleryId = $request->post->get('gallery_id');

        $settings = $this->getModel('settings')->get($galleryId);
        if($resourceId[0]['id']) {
            $photo = $this->getModel('photos')->getById($resourceId[0]['id']);
        }

        $settings->data['previewImage'] = $photo->attachment_id;

        $this->getModel('settings')->save($galleryId, $settings->data);

        update_option('previewImageId', $photo->attachment_id);

        return $this->response(Rsc_Http_Response::AJAX,
            array('url' => $this->generateUrl('galleries', 'settings', array('gallery_id' => $galleryId)),
                'message' => 'Preview image successfully changed'
            )
        );
    }

    //Uncomment to allow getting tooltips url
    /*public function getTooltipsUrlAction(Rsc_Http_Request $request) {
        $url = $this->getEnvironment()->getConfig()->get('plugin_url');

        return $this->response(Rsc_Http_Response::AJAX,
            array('url' => $url,
                'message' => 'Preview image successfully changed'
            )
        );
    }*/

    public function showPresetsAction(Rsc_Http_Request $request) {
        return $this->response('@galleries/gallery_preset.twig',
            array('url' => $this->generateUrl('galleries'))
        );
    }

    /**
     * Rename Action
     * Renames the specified gallery
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function renameAction(Rsc_Http_Request $request)
    {
        $lang = $this->getEnvironment()->getLang();
        $logger = $this->getEnvironment()->getLogger();

        $stats = $this->getEnvironment()->getModule('stats');
        $stats->save('galleries.rename');

        try {

            $this->getModel('galleries')->renameFromRequest($request, $lang);

        } catch (Exception $e) {

            if ($logger) {
                $logger->error(
                    'Invalid argument specified: {exception}',
                    array(
                        'exception' => $e,
                    )
                );
            }

            return $this->response(
                'ajax',
                $this->getErrorResponseData(
                    $e->getMessage()
                )
            );

        }

        return $this->response(
            'ajax',
            $this->getSuccessResponseData(
                $lang->translate('Title successfully updated')
            )
        );
    }

    /**
     * Delete Action
     * Deletes the gallery
     *
     * @param Rsc_Http_Request $request An instance of the HTTP request
     * @return Rsc_Http_Response
     */
    public function deleteAction(Rsc_Http_Request $request)
    {

        $env = $this->getEnvironment();
        $lang = $env->getLang();
        $logger = $env->getLogger();
        $prefix = $env->getConfig()->get('hooks_prefix');

        $stats = $this->getEnvironment()->getModule('stats');
        $stats->save('galleries.delete');

        try {

            $this->getModel('galleries')->deleteFromRequest(
                $request,
                $lang,
                $prefix
            );

        } catch (Exception $e) {

            if ($logger) {
                $logger->error(
                    'Failed to delete the gallery: {exception}',
                    array(
                        'exception' => $e,
                    )
                );
            }

            return $this->response(
                'ajax',
                $this->getErrorResponseData($e->getMessage())
            );
        }
        $membershipModel = $this->getModel('membership');
        $membershipModel->removeRowByGalleryId((int)$request->query->get('gallery_id'));
		$cleanAllCache = false;
		$settings = $this->getModel('settings')->get($request->query->get('gallery_id'));
		if($settings && property_exists($settings, 'data')) {
			$data = $settings->data;
			if(isset($data['plugins']['membership']['enable']) && $data['plugins']['membership']['enable'] == 1) {
				$cleanAllCache = true;
			}
		}

		$this->getModule('galleries')->cleanCache($request->query->get('gallery_id'), $cleanAllCache);
        return $this->redirect($this->generateUrl('galleries'));
    }

	/**
	 * Delete Group Action
	 * Deletes the gallery list
	 *
	 * @param Rsc_Http_Request $request An instance of the HTTP request
	 * @return Rsc_Http_Response
	 */
	public function deleteGroupAction(Rsc_Http_Request $request)
	{
		$env = $this->getEnvironment();
		$logger = $env->getLogger();

		$ids = $request->post->get('gallery_ids');

		foreach ($ids as $id) {
			try {
				$this->getModel('galleries')->delete(	$id );

			} catch (Exception $e) {

				if ($logger) {
					$logger->error(
						'Failed to delete the gallery: {exception}',
						array(
							'exception' => $e,
						)
					);
				}

				return $this->response(
					'ajax',
					$this->getErrorResponseData($e->getMessage())
				);
			}
		}


	}

    /**
     * Deletes the resources from the specified gallery.
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function deleteResourceAction(Rsc_Http_Request $request)
    {
        $resources = $this->getModel('resources');

        try {
            $resources->deleteFromRequest($request);
        } catch (Exception $e) {
            return $this->response(
                'ajax',
                $this->getErrorResponseData($e->getMessage())
            );
        }

        $this->getModule('galleries')->cleanCache($request->post->get('gallery_id'));

        return $this->response('ajax', $this->getSuccessResponseData('Deleted successfully.'));
    }

    /**
     * Shows the page with photos to attach them to the gallery.
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function addImagesAction(Rsc_Http_Request $request)
    {
        if (null === $galleryId = $request->query->get('gallery_id')) {
            // 404 - gallery not found
        }

        /** @var GridGallery_Galleries_Model_Galleries $galleries */
        $galleries = $this->getModel('galleries');
        $gallery = $galleries->getById($galleryId);


        return $this->response(
            '@galleries/add_images.twig',
            array(
                'gallery' => $gallery,
                'photos' => $this->getModel('photos')->getAllWithoutFolders(),
                'folders' => $this->getModel('folders')->getAll(),
                'viewType' => $request->query->get('view', 'block'),
            )
        );
    }

    /**
     * Settings Action.
     * Manage gallery settings
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function settingsAction(Rsc_Http_Request $request)
    {
        $galleryId = $request->query->get('gallery_id');

        $this->getEnvironment()->getConfig()->load('@galleries/tooltips.php');

        $tooltips = $this->getEnvironment()->getConfig()->get('tooltips');
        $icon = $this->getEnvironment()->getConfig()->get('tooltips_icon');

        $tooltips = array_map(array($this, 'rewrite'), $tooltips);

        $this->getEnvironment()->getTwig()->addGlobal('tooltips', $tooltips);
        $this->getEnvironment()->getTwig()->addGlobal('tooltips_icon', $icon);

        $twig = $this->getEnvironment()->getTwig();
        $twig->addFunction(
            new Twig_SimpleFunction(
                'get_image_src',
                'wp_get_attachment_image_src'
            )
        );

        $settings = $this->getModel('settings')->get($galleryId);
//        $preset   = $this->getModel('preset')->getBySettingsId($settings->id);
        if (!is_object($settings) || null === $settings->data) {
            $config = $this->getEnvironment()->getConfig();
            $config->load('@galleries/settings.php');

            $settings = new stdClass;

            $settings->id = null;
            $settings->data = unserialize($config->get('gallery_settings'));
        }

        $galleryModule = $this->getModule('galleries');
        $settings->data['socialSharing'] = $galleryModule->initGallerySocialShare($settings->data);
		$settings->data['rtl'] = is_rtl();

        $uiModule = $this->getModule('ui');
        $fontList = array_merge($this->getModel('settings')->getFontsList(), $uiModule->getStandardFontsList());
        sort($fontList);
        
		$membershipModel = $this->getModel('membership');
        $pageOptions = array(
        	'isSettingPage' => 1,
			'isMembershipPluginActive' => $membershipModel->isPluginActive(),
			'membershipInstallWpUrl' => $membershipModel->getPluginInstallWpUrl(),
			'membershipInstallUrl' => $membershipModel->getPluginInstallUrl(),
		);

		if($request->query['clone_type'] != null && $request->query['oldGalleryId'] != null) {
			$cloneType = $request->query['clone_type'];
			$oldGalleryId = $request->query['oldGalleryId'];
			if($cloneType != 2) {
				// Image optimize
				$imageOptimizeModel = $this->getModel('imageOptimize');
				$optimizeInfo = $imageOptimizeModel->getInfoByGalleryId($oldGalleryId);
				if(!empty($optimizeInfo[0]['service_code'])) {
					$ioServiceCode = $optimizeInfo[0]['service_code'];
					$requirements = $imageOptimizeModel->checkRequirements();
					$imgOptimizationSett = $this->getModel('optimization')->getServiceSettings();

					if(!$requirements && isset($imgOptimizationSett['setting'][$ioServiceCode]['auth_key'])) {
						$ioParams = $imgOptimizationSett;
						$ioParams["current"] = $ioServiceCode;
					}
				}
				// CDN
				$cdnModel = $this->getModel('cdn');
				$cdnServiceCode = $cdnModel->getServiceCodeByGalleryId($oldGalleryId);
				$cdnRequirements = $cdnModel->checkRequirements();
				if(!$cdnRequirements && !empty($cdnServiceCode[0]['service_code'])) {
					$cdnServiceCode = $cdnServiceCode[0]['service_code'];
					$cdnSett = $cdnModel->getServiceSettings();
					if(isset($cdnSett['setting'][$cdnServiceCode])) {
						$cdnParams = $cdnSett;
						$cdnParams['current'] = $cdnServiceCode;
					}
				}
			}
		}

        return $this->response(
            '@galleries/settings.twig',
            array(
                'gallery' => $this->getModel('galleries')->getById($galleryId),
                'settings' => $settings->data,
                'id' => $settings->id,
                // deprecated
                'preset' => null,
				'fontList' => $fontList,
				'pageOptions' => $pageOptions,
				'ioServiceParams' => isset($ioParams) ? json_encode($ioParams) : null,
				'cdnServiceParams' => isset($cdnParams) ? json_encode($cdnParams) : null,
				'pluginUrl' => $this->getModuleUrl(),
            )
        );
    }

	public function getModuleUrl() {
		return plugins_url('', __FILE__);
	}

    /**
     * Save Settings Action
     * Saves the specified gallery's settings
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function saveSettingsAction(Rsc_Http_Request $request)
    {
        /** @var GridGallery_Galleries_Model_Settings $settings */
        $galleryId = $request->query->get('gallery_id');
        $settings = $this->getModel('settings');
        $stats = $this->getEnvironment()->getModule('stats');
        $config = $this->getEnvironment()->getConfig();

        $postData = $request->post->all();

        if (isset($postData['socialSharing']['enabled']) && $postData['socialSharing']['enabled'] && isset($postData['socialSharing']['projectId'])){
            do_action('sss_show_at_grid_gallery', $postData['socialSharing']['projectId']);
        }

        $allSettings = $request->post->all();
        if(isset($allSettings['attributes']) && isset($allSettings['attributes']['order'])) {
            $allSettings['attributes']['order'] = json_decode($allSettings['attributes']['order']);
            $allSettings['attributes']['enable'] = json_decode($allSettings['attributes']['enable']);
            if(isset($allSettings['attributes']['rename'])) {
                $rename = json_decode($allSettings['attributes']['rename']);
                if(class_exists('GridGalleryPro_Galleries_Model_Attributes')) {
                    $attributesModel = new GridGalleryPro_Galleries_Model_Attributes();
                    $attributesModel->renameAttributes($galleryId, $rename);
                }
                unset($allSettings['attributes']['rename']);
            }
        }

        $settings->settingsDiff($stats, $galleryId, $allSettings);
        $data = $settings->getCatsFromPreset($allSettings, $config);
        $data = $settings->getPagesFromPreset($data, $config);

        if (!empty($data)) {
            $settings->save($galleryId, $data);
            $galleriesModel = $this->getModel('galleries');
            $galleriesModel->rename($galleryId, $data['title']);

			$removeWithOtherCache = false;
			if(isset($postData['plugins']['membership']['enable']) && $postData['plugins']['membership']['enable'] == 1) {
				$removeWithOtherCache = true;
			} else if(isset($data['plugins']['membership']['enable']) && $data['plugins']['membership']['enable'] == 1) {
				$removeWithOtherCache = true;
			}
			
			$this->getModule('galleries')->cleanCache($galleryId, $removeWithOtherCache);
        }

        // update membership parameter
		$settingsParamsArr = $settings->get($galleryId);
		$membershipModel = $this->getModel('membership');
        if($membershipModel->isPluginActive()) {
            $membershipModel->updateRow(array('gallery_id' => $galleryId, 'allow_use' => isset($settingsParamsArr->data['plugins']['membership']['enable']) ? $settingsParamsArr->data['plugins']['membership']['enable'] : 0));
        }

        return $this->redirect(
            $this->generateUrl(
                'galleries',
                'settings',
                array(
                    'gallery_id' => $request->query->get('gallery_id'),
                )
            )
        );
    }

    /**
     * Save custom categories preset
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function saveCatsPresetAction(Rsc_Http_Request $request) {
		if(isset($request->post['route']['options'])) {
			$data = $request->post['route']['options'];

            if(get_option('customCatsPresets')) {
				$presets = get_option('customCatsPresets');
			} else {
				$presets = array();
			}

			$presetsNames = $this->getModel('preset')->getCatsPresetsNames();
			$indx = array_search($data['preset']['name'], $presetsNames);

			if($indx) {
				$presets[$indx-1]['categories'] = $data['categories'];
			} else {
				array_push($presets, $data);
			}

			update_option('customCatsPresets', $presets);

			return $this->response(
				Rsc_Http_Response::AJAX,
				array(
					'success' => 'ok',
				)
			);
		}

		return $this->response(
			Rsc_Http_Response::AJAX,
			array(
				'success' => 'error',
			)
		);
    }

    /**
     *
     * Get categories custom presets
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function getCustomCatsPresetsAction(Rsc_Http_Request $request) {
        $presets = get_option('customCatsPresets');
        $names = array();

        if($presets) {
            foreach($presets as $preset) {
                array_push($names, $preset['preset']['name']);
            }
        }

        return $this->response(
            Rsc_Http_Response::AJAX,
            array(
                'names' => $names
            )
        );
    }

    /**
     * Save pages custom preset
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function savePagesPresetAction(Rsc_Http_Request $request) {
		if(isset($request->post['route']['options'])) {
			$data = $request->post['route']['options'];
			if(get_option('customPagesPresets')) {
				$presets = get_option('customPagesPresets');
			} else {
				$presets = array();
			}

			$presetsNames = $this->getModel('preset')->getPagesPresetsNames();
			$indx = array_search($data['preset']['name'], $presetsNames);

			if($indx) {
				$presets[$indx-1]['pagination'] = $data['pagination'];
			} else {
				array_push($presets, $data);
			}

			update_option('customPagesPresets', $presets);

			return $this->response(
				Rsc_Http_Response::AJAX,
				array(
					'success' => 'ok',
				)
			);
		}

		return $this->response(
			Rsc_Http_Response::AJAX,
			array(
				'success' => 'error',
			)
		);
    }

    /**
     *
     * Get pages custom presets
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function getCustomPagesPresetsAction(Rsc_Http_Request $request) {
        $presets = get_option('customPagesPresets');
        $names = array();

        if($presets) {
            foreach($presets as $preset) {
                array_push($names, $preset['preset']['name']);
            }
        }

        return $this->response(
            Rsc_Http_Response::AJAX,
            array(
                'names' => $names
            )
        );
    }

    /**
     * Save Preset Action
     * Saves the settings preset to the database.
     * @param Rsc_Http_Request $request HTTP request.
     * @return Rsc_Http_Response
     */
    public function savePresetAction(Rsc_Http_Request $request)
    {
        $preset = $this->getModel('preset');
        $settingsId = $request->post->get('settings_id');
        $presetTitle = $request->post->get('title');

        $lang = $this->getEnvironment()->getLang();

        if (empty($settingsId) || empty($presetTitle)) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData(
                    $lang->translate('Not enough data.')
                )
            );
        }

        if ($preset->set($settingsId, $presetTitle)) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getSuccessResponseData(
                    $lang->translate('Preset successfully saved.')
                )
            );
        }

        return $this->response(
            Rsc_Http_Response::AJAX,
            $this->getErrorResponseData(
                $lang->translate(
                    sprintf(
                        'Failed to save the preset: %s',
                        $preset->getLastError()
                    )
                )
            )
        );
    }

    /**
     * Remove Preset Action
     * Removes the settings preset by the preset id.
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function removePresetAction(Rsc_Http_Request $request)
    {
        $preset = $this->getModel('preset');
        $presetId = $request->post->get('preset_id');

        $lang = $this->getEnvironment()->getLang();

        if (null === $presetId || empty($presetId)) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData(
                    $lang->translate('The preset ID is not specified.')
                )
            );
        }

        if ($preset->remove($presetId)) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getSuccessResponseData(
                    $lang->translate('Preset successfully removed.')
                )
            );
        }

        return $this->response(
            Rsc_Http_Response::AJAX,
            $this->getErrorResponseData(
                $lang->translate(
                    sprintf(
                        'Failed to remove the preset: %s.',
                        $preset->getLastError()
                    )
                )
            )
        );
    }

    public function getPresetListAction()
    {
        return $this->response(
            Rsc_Http_Response::AJAX,
            array(
                'error' => false,
                'presets' => $this->getModel('preset')->getAll(),
            )
        );
    }

    public function applyPresetAction(Rsc_Http_Request $request)
    {
        $galleryId = $request->post->get('gallery_id');
        $presetId = $request->post->get('preset_id');

        $presets = $this->getModel('preset');
        $settings = $this->getModel('settings');

        $lang = $this->getEnvironment()->getLang();

        $preset = $presets->getById($presetId);

        if (!$preset) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData(
                    $lang->translate('Failed to find the preset.')
                )
            );
        }

        $settings->save($galleryId, $preset->settings->data);

        return $this->response(
            Rsc_Http_Response::AJAX,
            $this->getSuccessResponseData(
                $lang->translate('Preset successfully applied to the gallery.')
            )
        );
    }

	public function getCatsPresetOptionsAction(Rsc_Http_Request $request)
	{
		if(isset($request->post['route']['selectedPreset'])) {
			$selectedPreset = $request->post['route']['selectedPreset'];
			$presetsNames = $this->getModel('preset')->getCatsPresetsNames();
			$dbPresetOpt = get_option('customCatsPresets');
			$indx = array_search($selectedPreset, $presetsNames);
			if($indx) {
				$presetOptions = $dbPresetOpt[$indx-1]['categories'];
				return $this->response(
					Rsc_Http_Response::AJAX,
					array(
						'dialogType' => 'customized',
						'presetName' => $selectedPreset,
						'presetOptions' => $presetOptions
					)
				);
			}
		}

		return $this->response(
			Rsc_Http_Response::AJAX,
			array(
				'dialogType' => 'standart'
			)
		);
	}

	public function getPagesPresetOptionsAction(Rsc_Http_Request $request)
	{
		if(isset($request->post['route']['selectedPreset'])) {
			$selectedPreset = $request->post['route']['selectedPreset'];
			$presetsNames = $this->getModel('preset')->getPagesPresetsNames();
			$dbPresetOpt = get_option('customPagesPresets');
			$indx = array_search($selectedPreset, $presetsNames);
			if($indx) {
				$presetOptions = $dbPresetOpt[$indx-1]['pagination'];
				return $this->response(
					Rsc_Http_Response::AJAX,
					array(
						'dialogType' => 'customized',
						'presetName' => $selectedPreset,
						'presetOptions' => $presetOptions
					)
				);
			}
		}

		return $this->response(
			Rsc_Http_Response::AJAX,
			array(
				'dialogType' => 'standart'
			)
		);
	}

    public function checkReviewNoticeAction(Rsc_Http_Request $request) {
        $showNotice = get_option('showGalleryRevNotice');
        $show = false;

        if (!$showNotice) {
            update_option('showGalleryRevNotice', array(
                'date' => time(),
                'is_shown' => false
            ));
        } else {
            if ($showNotice['date'] instanceof DateTime) {
                $showNotice['date'] = $showNotice['date']->getTimestamp();
            }
            $days = floor((time() - $showNotice['date']) / (60*60*24));
            if ($days > 7 && $showNotice['is_shown'] != true) {
                $show = true;
            }
        }

        return $this->response(
            Rsc_Http_Response::AJAX,
            array('show' => $show)
        );
    }

    public function checkNoticeButtonAction(Rsc_Http_Request $request) {
        $code = 'is_shown';
        $showNotice = get_option('showGalleryRevNotice');

        if($code == 'is_shown') {
            $showNotice['is_shown'] = true;
        } else {
            $showNotice['date'] = time();
        }

        $this->sendUsageStat($code);
        update_option('showGalleryRevNotice', $showNotice);

        return $this->response(Rsc_Http_Response::AJAX);
    }

    public function sendUsageStat($state) {
        $apiUrl = 'http://updates.supsystic.com';

        $reqUrl = $apiUrl . '?mod=options&action=saveUsageStat&pl=rcs';
        $res = wp_remote_post($reqUrl, array(
            'body' => array(
                'site_url' => get_bloginfo('wpurl'),
                'site_name' => get_bloginfo('name'),
                'plugin_code' => 'sgg',
                'all_stat' => array('views' => 'review', 'code' => $state),
            )
        ));

        return true;
    }

    /**
     * Rewrites @url annotation to the full url.
     *
     * @param string $element
     * @return string
     */
    public function rewrite($element)
    {
        $cdnUrl = $this->getEnvironment()->getModule('core')->getCdnUrl();
        $element = str_replace('@cdn_url', $cdnUrl, $element);

        $url = $this->getEnvironment()->getConfig()->get('plugin_url');

        return str_replace('@url', $url . '/app/assets/img', $element);
    }

    public function ajaxGetImagesAction(Rsc_Http_Request $request)
    {
        if (null === $galleryId = $request->post->get('gallery_id')) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData(
                    'Gallery identifier is not specified.'
                )
            );
        }

        /** @var GridGallery_Galleries_Model_Galleries $galleries */
        $galleries = $this->getModel('galleries');

        if (null === $gallery = $galleries->getById((int)$galleryId)) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData('The gallery does not exists.')
            );
        }

        $gallery->settings = $this->getModel('settings')->get($galleryId)->data;

        return $this->response(
            Rsc_Http_Response::AJAX,
            $this->getSuccessResponseData(
                null,
                array(
                    'photos' => $gallery->photos,
                    'area' => $gallery->settings['area']
                )
            )
        );
    }

    public function ajaxResizeImageAction(Rsc_Http_Request $request)
    {
        if (!function_exists('wp_get_image_editor')) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData(
                    'Current WordPress revision has not Image Editor.'
                )
            );
        }

        $attachmentId = $request->post->get('attachment_id');
        $width = $request->post->get('width');
        $height = $request->post->get('height');

        if (!$attachmentId) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData(
                    'The attachment id is not specified.'
                )
            );
        }

        $meta = wp_get_attachment_metadata($attachmentId);
        $upload = wp_upload_dir();

        if (!is_file($file = $upload['basedir'] . '/' . $meta['file'])) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData(
                    sprintf('File not found: %s', $file)
                )
            );
        }

        if (!$width || !$height) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData('Width or Height is not specified.')
            );
        }

        $editor = wp_get_image_editor($file);

        if (is_wp_error($editor)) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData(
                    sprintf('Unable to load the image: %s', $file)
                )
            );
        }

        if (is_wp_error($error = $editor->resize((int)$width, (int)$height, true))) {
            return $this->response(
                Rsc_Http_Response::AJAX,
                $this->getErrorResponseData(
                    sprintf(
                        'Unable to resize the image: %s.',
                        $file
                    ),
                    array(
                        'reason' => $error->get_error_message(),
                    )
                )
            );
        }

        $image = $editor->save();

        return $this->response(
            Rsc_Http_Response::AJAX,
            $this->getSuccessResponseData(
                sprintf('Attachment %s resized successfully.', $attachmentId),
                array(
                    'image' => $image
                )
            )
        );
    }

    /**
     * Save sort images by (Size, Name, Add date, Create Date)
     *
     * @param Rsc_Http_Request $request query post param
     * @return string msg Response answer
     */
    public function saveSortByAction(Rsc_Http_Request $request)
    {
        $galleryId = $request->post->get('gallery_id');

        $sort_fields['sort'] = array(
            "sortby" => $request->post->get('sortby'),
            "sortto" => $request->post->get('sortto')
        );

		global $wpdb;
		update_option($wpdb->prefix . $this->getConfig()->get('db_prefix') . 'rand_sorts', array(
			'id' => $galleryId,
			'val' => $sort_fields['sort']['sortby'] === 'randomly' ? true : false
		));

        $settings = $this->getModel('settings')->get($galleryId);
        $mydata = $settings->data;
        $mydata = array_merge($mydata, $sort_fields);

		// for pagination
		/*if($sort_fields['sort']['sortby'] == 'postion') {
			$resourceModel = $this->getModel('resources');
			$photoRows = $resourceModel->getPhotoIdsByGalleryId($galleryId);
			$positionModel = $this->getModel('position');
			$sortType = 1;
			if($sort_fields['sort']['sortto'] != 'asc') {
				$sortType = 0;
			}
			$positionModel->cleanAndCreate($galleryId, $photoRows, $sortType);
		}*/

        $this->getModel('settings')->save($galleryId, $mydata);
        $this->getModule('galleries')->cleanCache($galleryId);

        return $this->response(
            Rsc_Http_Response::AJAX,
            $this->getSuccessResponseData(
                "Save sorted"
            )
        );
    }

    public function getGalleriesListAction(Rsc_Http_Request $request)
    {
        $galleries = $this->getModel('galleries');

        return $this->response(
            Rsc_Http_Response::AJAX, array(
                'list' => $galleries->getList(),
            )
        );
    }

    public function importSettingsAction(Rsc_Http_Request $request)
    {
        $settingsModel = $this->getModel('settings');
        $from = $request->post->get('from');
        $to = $request->post->get('to');
        $settings = $settingsModel->get($from);
        $settingsModel->save($to, $settings->data);
        $this->getModule('galleries')->cleanCache($to, true);
        return $this->response(
            Rsc_Http_Response::AJAX, array(
                'success' => true,
            )
        );
    }

	protected function getCloneParams() {
		// 	not copied tables: gg_folders, gg_photos, gg_photos_settings, gg_settings_presets, gg_stats
		$environment = $this->getEnvironment();
		return array(
			'environment' => $environment,
			//'socialSharing' => 'GridGallery_Galleries_Model_SocialSharing',
			//'preset' => $this->getModel('preset'),
			//'photos' => $this->getModel('photos'),
			//'folders' => $this->getModel('folders'),
			'resources' => $this->getModel('resources'),
			'settings' => $this->getModel('settings'),
			'position' => $this->getModel('position'),
			'membership' => $this->getModel('membership'),
			'cdn' => $this->getModel('cdn'),
		);
	}

	public function cloneAction(Rsc_Http_Request $request) {
		$route = $request->post->get("route");
		$oldGalleryId = null;
		$result = array(
			'isError' => true,
			'message' => $this->translate('Gallery clone error'),
		);
		if(isset($route['gallery_id']) && isset($route['clone_type'])) {
			$oldGalleryId = (int) $route['gallery_id'];
			$cloneType = $route['clone_type'];
			if($oldGalleryId && $cloneType) {
				$galleryModel = $this->getModel('galleries');
				$result = $galleryModel->cloneGallery($oldGalleryId, $cloneType, $this->getCloneParams());
			}
		}
		return $this->response(Rsc_Http_Response::AJAX, $result);
	}

	public function createDefaultGallerySettingsAction(Rsc_Http_Request $request){
		$galleryId = $request->post->get("id");
		update_option('defaultgallerysettings', $galleryId);

		return $this->response(
			Rsc_Http_Response::AJAX, array(
				'success' => true,
				'message' => 'success',
			)
		);

	}

	public function removeDefaultGallerySettingsAction(Rsc_Http_Request $request){
		$galleryId = $request->post->get("id");
		delete_option('defaultgallerysettings', $galleryId);

		return $this->response(
			Rsc_Http_Response::AJAX, array(
				'success' => true,
				'message' => 'success',
			)
		);
	}
}
