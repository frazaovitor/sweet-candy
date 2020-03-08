<?php
class GridGallery_Optimization_Model_Optimization extends GridGallery_Core_BaseModel {

	public static $restoreSubFolder = "io-backup";

	public function __construct() {
		parent::__construct();
	}

	public static function getServiceOptionName() {
		return 'sgg_img_optimize_service_settings';
	}

	public function getServiceSettings() {
		$imgOptSett = @unserialize(get_option(self::getServiceOptionName(), null));

		// reset invalid configuration
		if(empty($imgOptSett['current']) || empty($imgOptSett['setting']) || empty($imgOptSett['setting'][$imgOptSett['current']])) {
			$imgOptSett = array(
				'current' => 'tinypng',
				'setting' => array(
					'tinypng' => array(
						'auth_key' => ''
					)
				)
			);
		}
		return $imgOptSett;
	}

	public static function saveServiceSettings($settings) {
		$prepareSett = serialize($settings);
		if($prepareSett) {
			update_option(self::getServiceOptionName(), $prepareSett);
			return true;
		}
		return false;
	}

	public static function addSubFolderToUrl($url, $subFolder) {
		$lastPos = strrpos($url, '/');
		$newUrl = null;
		if($lastPos !== false) {
			$newUrl = substr($url, 0, $lastPos) . '/'
				. $subFolder
				. substr($url, $lastPos);
		}
		return $newUrl;
	}

	public static function calcOptimizePercent($srcSize, $optimizedSize) {
		return round(100 - ($optimizedSize*100/$srcSize), 2);
	}

	public static function getSeviceNameByCode($code) {
		if($code == 'tinypng') {
			return 'TinyPNG';
		}
		return null;
	}

	public static function getSizeInMb($sizeInBytes) {
		return number_format($sizeInBytes / 1048576, 2);
	}

	public function calcGalleryCurrentSize($galleryId, $attachmentSimpleModel, $resourcesModel, $photoModel, $gallerySettings, $optimizePreview = true, &$photoOptCount = 0) {

		$gallerySize = 0.0;
		$photoOptCount = 0;

		$galleryId = intval($galleryId);
		if($galleryId){
			$galleryObject = $gallerySettings->get($galleryId);
			$currGalleryResourcesData = $resourcesModel->getByGalleryId($galleryId);
			$currGalleryPhotoInfo = $photoModel->getPhotos($currGalleryResourcesData);

			if(count($currGalleryPhotoInfo) > 0) {
				if($optimizePreview && isset($galleryObject->data)) {
					$gallerySett = GridGallery_Galleries_Attachment::prepareWmImgParamsFromGallerySett($galleryObject);
				}

				foreach($currGalleryPhotoInfo as $onePhoto) {
					if(isset($onePhoto->attachment['url'])) {
						// main Photo
						$filePath = $attachmentSimpleModel->replaceUrlToFilePath($onePhoto->attachment['url']);
						$gallerySize += filesize($filePath);
						$photoOptCount++;

						if($optimizePreview) {
							// get Thumbnail Image Url
							$calcAttachUrl = $attachmentSimpleModel->getAttachment(
								$onePhoto->attachment_id, $gallerySett['photo_width'],
								$gallerySett['photo_height'],
								isset($onePhoto->attachment['cropPosition']) ? $onePhoto->attachment['cropPosition'] : null,
								$gallerySett['crop_quality']
							);
							if($calcAttachUrl && $onePhoto->attachment['url'] != $calcAttachUrl) {
								$filePath = $attachmentSimpleModel->replaceUrlToFilePath($calcAttachUrl);
								$gallerySize += filesize($filePath);
								$photoOptCount++;
							}
						}
					}
				}
			}
		}
		return $gallerySize;
	}

	public function restorePreviousFiles($galleryId, $resources, $photoModel, $currGallerySettings, $imgOptimize) {
		$attachmentSimpleModel = new GridGallery_Galleries_Attachment();
		if($galleryId) {

			$currGalleryResourcesData = $resources->getByGalleryId($galleryId);
			$currGalleryPhotoInfo = $photoModel->getPhotos($currGalleryResourcesData);

			if(count($currGalleryPhotoInfo) > 0) {
				$gallerySett = GridGallery_Galleries_Attachment::prepareWmImgParamsFromGallerySett($currGallerySettings);

				foreach($currGalleryPhotoInfo as $onePhoto) {
					if(isset($onePhoto->attachment['url'])) {
						$restorePath = $restoreUrl = self::addSubFolderToUrl($onePhoto->attachment['url'], self::$restoreSubFolder);
						$photos[] = array(
							'r' => $attachmentSimpleModel->replaceUrlToFilePath($restorePath),
							'o' => $attachmentSimpleModel->replaceUrlToFilePath($onePhoto->attachment['url'])
						);

						// get Thumbnail Image Url
						$calcAttachUrl = $attachmentSimpleModel->getAttachment(
							$onePhoto->attachment_id, $gallerySett['photo_width'],
							$gallerySett['photo_height'],
							isset($onePhoto->attachment['cropPosition']) ? $onePhoto->attachment['cropPosition'] : null,
							$gallerySett['crop_quality']
						);
						if($calcAttachUrl && $onePhoto->attachment['url'] != $calcAttachUrl) {
							$restorePath = $restoreUrl = self::addSubFolderToUrl($calcAttachUrl, self::$restoreSubFolder);
							$photos[] = array(
								'r' => $attachmentSimpleModel->replaceUrlToFilePath($restorePath),
								'o' => $attachmentSimpleModel->replaceUrlToFilePath($calcAttachUrl)
							);
						}
					}
				}
			}
		}

		if(count($photos) > 0) {
			// copy Old files
			foreach($photos as $elem) {
				if(isset($elem['r']) && isset($elem['o']) && file_exists($elem['r'])) {
					if(copy($elem['r'], $elem['o'])) {
						unlink($elem['r']);
					}
				}
			}

			// remove record from db
			$imgOptimize->removeByGalleryId($galleryId);
		}
	}
}