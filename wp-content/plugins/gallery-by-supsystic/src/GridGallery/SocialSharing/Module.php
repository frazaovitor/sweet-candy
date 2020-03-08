<?php

/**
 * Class GridGallery_SocialSharing_Module for work with social share plugin
 */
class GridGallery_SocialSharing_Module extends GridGallery_Core_Module{

	public function onInit()
	{
		parent::onInit();
		add_action('sgg_disable_social_sharing',array($this,'disableSocialSharing'),10,1);
		add_action('sgg_clean_cache',array($this,'cleanSocialSharingCache'),10,1);
		add_action('parse_request', array($this, 'onRequest'));
	}


	public function cleanSocialSharingCache($projectId){
		/**
		 * @var GridGallery_Galleries_Module $galleryModule
		 * @var GridGallery_Galleries_Model_Galleries $galleryModel
		 * @var GridGallery_Galleries_Model_Settings $settingsModel
		 */
		$galleryModule = $this->getEnvironment()->getModule('galleries');
		$galleryModel = $galleryModule->getModel('galleries');
		$settingsModel = $galleryModule->getModel('settings');

		$galleriesList = $galleryModel->getList();
		foreach($galleriesList as $gallery){
			$settings = $settingsModel->get($gallery->id);
			if($settings->data['socialSharing']['projectId'] == $projectId){
				$galleryModule->cleanCache($gallery->id);
			}
		}
	}

	/**
	 * disable social sharing in gallery if project setting "where_to_show" where changed from
	 * "grid_gallery" to something else
	 * @param int $projectId id of social sharing project
  	*/
	public function disableSocialSharing($projectId){
		/**
		 * @var GridGallery_Galleries_Module $galleryModule
		 * @var GridGallery_Galleries_Model_Galleries $galleryModel
		 * @var GridGallery_Galleries_Model_Settings $settingsModel
		 */
		$galleryModule = $this->getEnvironment()->getModule('galleries');
		$galleryModel = $galleryModule->getModel('galleries');
		$settingsModel = $galleryModule->getModel('settings');

		$galleriesList = $galleryModel->getList();
		foreach($galleriesList as $gallery){
			$settings = $settingsModel->get($gallery->id);
			if(isset($settings->data['socialSharing']['projectId']) && $settings->data['socialSharing']['projectId'] == $projectId){
				$settings->data['socialSharing']['enabled'] = false;
				$settingsModel->save($gallery->id,$settings->data);
				$galleryModule->cleanCache($gallery->id);
			}
		}
	}

	public function onRequest(){

		if (!isset($_GET['shared-image'])) {
			return;
		}

		$current_url = site_url(remove_query_arg(''));
		$redirect_url = site_url(remove_query_arg('shared-image'));

		$photoId = intval($_GET['shared-image']);
		$photoModel = new GridGallery_Photos_Model_Photos();
		$attachment = new GridGallery_Galleries_Attachment();
		$photoData = $photoModel->getById($photoId);
		
		if (!$photoData) {
			return;
		}

		$url = $attachment->getAttachment($photoData->attachment['id'], 1000);

		$title = strip_tags(preg_replace('/<br[^>]*>/',' ', htmlspecialchars_decode($photoData->attachment['caption'])));
		$description = strip_tags(preg_replace('/<br[^>]*>/',' ', htmlspecialchars_decode($photoData->attachment['description'])));

		die($this->getEnvironment()->getTwig()->render(
			'@socialsharing/shareImage.twig',
			array(
				'title' => $title,
				'description' => $description,
				'img_url' => $url,
				'current_url' => $current_url,
				'redirect_url' => $redirect_url,
			)
		));

	}
}