<?php
class GridGallery_Optimization_Controller extends GridGallery_Core_BaseController {

	public function requireNonces() {
		return array(
			'saveSettingsAction',
			'getPhotoListAction',
			'optimizeOneImageAction',
			'saveOptimizeInfoToDbAction',
			'rollbackRestoredImgAction',
			'saveCdnSettingsAction',
			'transferOneImageAction',
			'saveCdnInfoToDbAction',
		);
	}

	protected function getModelAliases() {
		return array(
			'galleries' => 'GridGallery_Galleries_Model_Galleries',
			'resources' => 'GridGallery_Galleries_Model_Resources',
			'settings' => 'GridGallery_Galleries_Model_Settings',
			'photos' => 'GridGallery_Photos_Model_Photos',
			'optimization' => 'GridGallery_Optimization_Model_Optimization',
			'imageOptimize' => 'GridGallery_Optimization_Model_ImageOptimize',
			'cdn' => 'GridGallery_Optimization_Model_Cdn',
			'encrypt' => 'GridGallery_Optimization_Model_Encrypt',
		);
	}

	public function indexAction(Rsc_Http_Request $request) {

		$imageOptimizeModel = $this->getModel('imageOptimize');
		$requirements = $imageOptimizeModel->checkRequirements();

		if(!$requirements) {
			$imgOptimizationSett = $this->getModel('optimization')->getServiceSettings();
			$galleryList = $this->getModel('galleries')->getList();
			$this->getModel('imageOptimize')->extendGalleryImageOptimizeInfo($galleryList);
			$this->getModel('resources')->extendGalleryPhotoCount($galleryList);
			$statistic = $imageOptimizeModel->getStatistic();

			$cdnModel = $this->getModel('cdn');
			// check cdn table exists
			$cdnRequirements = $cdnModel->checkRequirements();
			if(!$cdnRequirements) {
				$cdnSett = $cdnModel->getServiceSettings();
				$cdnModel->extendGalleryList($galleryList);
			} else {
				$cdnSett = null;
			}

			$tabName = null;
			if(isset($request->query['sggtab'])) {
				$tabAllowList = array('img', 'cdn');
				$tabName = strtolower($request->query['sggtab']);
				if(!in_array($tabName, $tabAllowList)) {
					$tabName = null;
				}
			}

			return $this->response(
				'@optimization/index.twig',
				array(
					'imgOptimizationSett' => $imgOptimizationSett,
					'galleryList' => $galleryList,
					'statistic' => $statistic,
					'tabName' => $tabName,
					'cdnSett' => $cdnSett,
					'cdnRequirements' => $cdnRequirements,
				)
			);
		} else {
			return $this->response(
				'@optimization/error.twig',
				array(
					'info' => $requirements,
				)
			);
		}
	}

	public function saveSettingsAction(Rsc_Http_Request $request) {

		$message = $this->translate('Error occurred');
		$isSuccess = false;

		$data = isset($request->post['route']['data']) ? $request->post['route']['data'] : null;
		if($data) {
			if(isset($data['setting_type'])) {
				if($data['setting_type'] == 'tinypng' && !empty($data['params']['auth_key'])) {

					$settings = $this->getModel('optimization')->getServiceSettings();
					$settings['setting']['tinypng']['auth_key'] = $data['params']['auth_key'];
					$this->getModel('optimization')->saveServiceSettings($settings);

					$message = $this->translate('Auth key saved!');
					$isSuccess = true;
				}
			}
		}
		return $this->response(Rsc_Http_Response::AJAX, array(
			'success' => $isSuccess,
			'message' => $message,
		));
	}

	public function saveCdnSettingsAction(Rsc_Http_Request $request) {

		$message = $this->translate('Error occurred');
		$isSuccess = false;

		$data = isset($request->post['route']['data']) ? $request->post['route']['data'] : null;
		if($data) {
			if(isset($data['setting_type'])) {
				$cdnModel = $this->getModel('cdn');
				$encryptModel = $this->getModel('encrypt');
				if($data['setting_type'] == 'keycdn' && !empty($data['params']['zone_name'])) {
					$settings = $cdnModel->getServiceSettings();
					$settings['setting']['keycdn']['zone_name'] = $data['params']['zone_name'];
					$settings['setting']['keycdn']['u_name'] = !empty($data['params']['u_name']) ? $data['params']['u_name'] : null;
					$settings['setting']['keycdn']['base_ftp_path'] = !empty($data['params']['base_ftp_path']) ? $data['params']['base_ftp_path'] : null;

					if(!empty($data['params']['u_pass'])) {
						$settings['setting']['keycdn']['u_pass'] = $encryptModel->encrypt($data['params']['u_pass']);
					} else {
						$settings['setting']['keycdn']['u_pass'] = $encryptModel->encrypt('');
					}

					$cdnModel->saveServiceSettings($settings);
					$message = $this->translate('Service data was saved!');
					$isSuccess = true;
				}
			}
		}
		return $this->response(Rsc_Http_Response::AJAX, array(
			'success' => $isSuccess,
			'message' => $message,
		));
	}

	public function getPhotoListAction(Rsc_Http_Request $request) {
		$message = $this->translate('Error occurred');
		$isSuccess = false;

		$photos = array();
		$route = $request->post->get("route");

		if(isset($route['data']) && isset($route['data']['galleries'])) {
			$isSuccess = true;
			$message = "Galleries info loaded";
			$somePhoto = null;
			$galleryInfo = array();

			$galleryArr = $route['data']['galleries'];
			if(count($galleryArr) > 0) {

				$optimizePreview = false;
				$attachmentSimpleModel = new GridGallery_Galleries_Attachment();
				$resources = $this->getModel('resources');
				$photoModel = $this->getModel('photos');

				if(isset($route['data']['optimize-preview']) && $route['data']['optimize-preview'] == 1) {
					$optimizePreview = true;
				}

				$gallKeyList = array_keys($galleryArr);
				foreach($gallKeyList as $galleryId) {
					$galleryId = intval($galleryId);
					if($galleryId){
						if(isset($galleryArr[$galleryId]['imglist']) && is_array($galleryArr[$galleryId]['imglist'])) {
							$somePhoto = $galleryArr[$galleryId]['imglist'];
						}
						$galleryInfo[$galleryId]['size'] = 0;
						$currGallerySettings = $this->getModel('settings')->get($galleryId);
						$currGalleryResourcesData = $resources->getByGalleryId($galleryId);
						$currGalleryPhotoInfo = $photoModel->getPhotos($currGalleryResourcesData);

						if(count($currGalleryPhotoInfo) > 0) {
							if($optimizePreview && isset($currGallerySettings->data)) {
								$settingsForWmPreview = GridGallery_Galleries_Attachment::prepareWmImgParamsFromGallerySett($currGallerySettings);
							}

							foreach($currGalleryPhotoInfo as $onePhoto) {
								if(isset($onePhoto->attachment['url'])) {
									$currFilePath = $attachmentSimpleModel->replaceUrlToFilePath($onePhoto->attachment['url']);

									if($somePhoto == 0) {
										$photos[$galleryId][] = $onePhoto->attachment['url'];
									}
									$galleryInfo[$galleryId]['size'] += filesize($currFilePath);

									if($optimizePreview) {
										// get Thumbnail Image Url
										$calcAttachUrl = $attachmentSimpleModel->getAttachment(
											$onePhoto->attachment_id,
											$settingsForWmPreview['photo_width'],
											$settingsForWmPreview['photo_height'],
											isset($onePhoto->attachment['cropPosition']) ? $onePhoto->attachment['cropPosition'] : null,
											$settingsForWmPreview['crop_quality']
										);
										if($calcAttachUrl && $onePhoto->attachment['url'] != $calcAttachUrl) {
											$currFilePath = $attachmentSimpleModel->replaceUrlToFilePath($calcAttachUrl);
											if($somePhoto == 0) {
												$photos[$galleryId][] = $calcAttachUrl;
											}
											$galleryInfo[$galleryId]['size'] += filesize($currFilePath);
										}
									}
								}
							}
						}
					}
				}
			}
		}

		return $this->response(Rsc_Http_Response::AJAX, array(
			'success' => $isSuccess,
			'message' => $message,
			'photos' => $photos,
			'galleryInfo' => $galleryInfo,
		));
	}

	public function getCdnPhotoListAction(Rsc_Http_Request $request) {
		$message = $this->translate('Error occurred');
		$isSuccess = false;

		$photos = array();
		$route = $request->post->get("route");

		if(isset($route['data']) && isset($route['data']['galleries'])) {
			$isSuccess = true;
			$message = "Galleries info loaded";
			$galleryInfo = array();

			$galleryArr = $route['data']['galleries'];
			if(count($galleryArr) > 0) {

				$this->prepareCdnPhotoList($route, $galleryArr, $photos, $galleryInfo);
			}
		}

		return $this->response(Rsc_Http_Response::AJAX, array(
			'success' => $isSuccess,
			'message' => $message,
			'photos' => $photos,
			'galleryInfo' => $galleryInfo,
		));
	}

	public function prepareCdnPhotoList($route, $galleryArr, &$photos, &$galleryInfo) {
		$optimizePreview = false;
		$attachmentSimpleModel = new GridGallery_Galleries_Attachment();
		$resources = $this->getModel('resources');
		$photoModel = $this->getModel('photos');

		if(isset($route['data']['optimize-preview']) && $route['data']['optimize-preview'] == 1) {
			$optimizePreview = true;
		}

		$gallKeyList = array_keys($galleryArr);
		foreach($gallKeyList as $galleryId) {
			$galleryId = intval($galleryId);
			if($galleryId){
				$galleryInfo[$galleryId]['size'] = 0;
				$currGallerySettings = $this->getModel('settings')->get($galleryId);
				$currGalleryResourcesData = $resources->getByGalleryId($galleryId);
				$currGalleryPhotoInfo = $photoModel->getPhotos($currGalleryResourcesData);

				if(count($currGalleryPhotoInfo) > 0) {
					if($optimizePreview && isset($currGallerySettings->data)) {
						$settingsForWmPreview = GridGallery_Galleries_Attachment::prepareWmImgParamsFromGallerySett($currGallerySettings);
					}

					foreach($currGalleryPhotoInfo as $onePhoto) {
						if(isset($onePhoto->attachment['url'])) {
							$photoToAdd = array();
							$photoToAdd['img_url'] = $onePhoto->attachment['url'];
							$photoToAdd['attachment_id'] = $onePhoto->attachment_id;
							$galleryInfo[$galleryId]['size'] += filesize($attachmentSimpleModel->replaceUrlToFilePath($photoToAdd['img_url']));

							if($optimizePreview) {
								// get Thumbnail Image Url
								$calcAttachUrl = $attachmentSimpleModel->getAttachment(
									$onePhoto->attachment_id,
									$settingsForWmPreview['photo_width'],
									$settingsForWmPreview['photo_height'],
									isset($onePhoto->attachment['cropPosition']) ? $onePhoto->attachment['cropPosition'] : null,
									$settingsForWmPreview['crop_quality']
								);
								if($calcAttachUrl && $onePhoto->attachment['url'] != $calcAttachUrl) {
									$photoToAdd['preview_url'] = $calcAttachUrl;
									$galleryInfo[$galleryId]['size'] += filesize($attachmentSimpleModel->replaceUrlToFilePath($photoToAdd['preview_url']));
								}
							}
							$photos[$galleryId][] = $photoToAdd;
						}
					}
				}
			}
		}
		return true;
	}

	public function optimizeOneImageAction(Rsc_Http_Request $request) {

		$message = $this->translate('Error occurred');
		$isSuccess = false;
		$serviceError = null;

		$route = $request->post->get("route");
		if(isset($route['data'])) {
			$data = $route['data'];
			if(isset($route['data']['currentServiceCode']) && isset($route['data']['auth_data']) && isset($route['data']['url'])) {
				if($route['data']['currentServiceCode'] == 'tinypng') {
					require_once "lib/ImageOptimizeInterface.php";
					require_once "lib/Tinify/Exception.php";
					require_once "lib/Tinify/ResultMeta.php";
					require_once "lib/Tinify/Result.php";
					require_once "lib/Tinify/Source.php";
					require_once "lib/Tinify/Client.php";
					require_once "lib/Tinify/Tinify.php";
					$service = new Tinify_Tinify();
				}

				if(isset($service)) {
					$answer = array();
					$attachmentModel = new GridGallery_Galleries_Attachment();
					$currFilePath = $attachmentModel->replaceUrlToFilePath($route['data']['url']);
					$isFileRestored = false;

					// only when we restore the copy of file
					if($data['restoreSrc'] == 1) {
						$restoreUrl = GridGallery_Optimization_Model_Optimization::addSubFolderToUrl($route['data']['url'], GridGallery_Optimization_Model_Optimization::$restoreSubFolder);
						$restoreFilePath = $attachmentModel->replaceUrlToFilePath($restoreUrl);
						$restoreDirectory = dirname($restoreFilePath);

						if(!file_exists($restoreDirectory)) {
							if(!mkdir($restoreDirectory, 0777, true)) {
								$message = $this->translate("Can't create restore directory!");
							}
						}
						// restore file once
						if(!file_exists($restoreFilePath)) {
							if(!copy($currFilePath, $restoreFilePath)) {
								$message = $this->translate("Can't create restore file!");
								$isFileRestored = null;
							} else {
								$answer['restoreSize'] = GridGallery_Optimization_Model_Optimization::getSizeInMb(filesize($restoreFilePath));
								$answer['restoreUrl'] = $restoreUrl;
								$isFileRestored = true;
							}
						}
					}

					if($isFileRestored === false) {
						$answer['restoreUrl'] = $route['data']['url'];
						$answer['restoreSize'] = GridGallery_Optimization_Model_Optimization::getSizeInMb(filesize($currFilePath));
					}

					if(isset($answer['restoreSize'])) {
						try {
							if(!$service->setConfiguration($route['data']['auth_data'])) {
								$message = $this->translate("Error! Incorrect auth params!");
							} else {
								$service->optimizeImage(array(
									'fileSrc' => realpath($currFilePath),
									'fileDest' => realpath($currFilePath),
								));
								$answer['optSize'] = GridGallery_Optimization_Model_Optimization::getSizeInMb(filesize($currFilePath));
								$isSuccess = true;
							}
						} catch(Exception $e1) {
							$message = $e1->getMessage();
							$serviceError = true;
						}
					}
				}
			}
		}

		return $this->response(Rsc_Http_Response::AJAX, array(
			'success' => $isSuccess,
			'message' => $message,
			'serviceError' => $serviceError,
			'imgInfo' => isset($answer) ? $answer : null,
		));
	}

	public function transferOneImageAction(Rsc_Http_Request $request) {
		$message = $this->translate('Error occurred');
		$isSuccess = false;
		$serviceError = false;
		$route = $request->post->get("route");

		if(isset($route['data'])) {
			$data = $route['data'];
			if(isset($data['auth_data']) && isset($data['auth_data']['setting'])
				&& isset($data['auth_data']['current']) && isset($data['auth_data']['setting'][$data['auth_data']['current']])
				&& $data['photoObj']) {

				$settings = $data['auth_data']['setting'][$data['auth_data']['current']];
				if($data['auth_data']['current'] == 'keycdn') {
					if(isset($settings['base_ftp_path']) && isset($settings['u_name'])
						&& isset($settings['u_pass']) && isset($settings['zone_name'])) {

						$encryptModel = $this->getModel('encrypt');
						$decryptedPassword = $encryptModel->decrypt($settings['u_pass']);

						$ftpModel = new GridGallery_Optimization_Model_Ftp(array(
							'host' => 'ftp.keycdn.com',
							'port' => null,
							'ftpUsername' => $settings['u_name'],
							'ftpPassword' => $decryptedPassword,
							'folderName' => $settings['base_ftp_path'],
						));

						$attachmentSimpleModel = new GridGallery_Galleries_Attachment();
						try {
							// upload image and preview
							$this->transferToCdnOnePhotoObj($ftpModel, $attachmentSimpleModel, $data['photoObj'], $data['isDelete']);
							$isSuccess = true;
						} catch(Exception $e1) {
							$message = $e1->getMessage();
							if($ftpModel->authError) {
								$serviceError = true;
							}
						}
					} else {
						$serviceError = true;
						$message = $this->translate('Error! Incorrect service params!');
					}
				} else {
					$message = $this->translate('Error! Incorrect selected service!');
				}
			}
		} else {
			$message = $this->translate('Error! Incorrect params!');
		}

		return $this->response(Rsc_Http_Response::AJAX, array(
			'success' => $isSuccess,
			'message' => $message,
			'serviceError' => $serviceError,
		));
	}

	public function saveOptimizeInfoToDbAction(Rsc_Http_Request $request) {
		$message = $this->translate('Error occurred');
		$isSuccess = false;
		$route = $request->post->get("route");

		if(isset($route['data']['serviceCode']) && count($route['data']) > 1) {
			$serviceCode = $route['data']['serviceCode'];
			unset($route['data']['serviceCode']);
			$isRestore = $route['data']['isRestore'];
			unset($route['data']['isRestore']);
			$isOptimizePreview = $route['data']['optimizePreview'];
			unset($route['data']['optimizePreview']);

			$attachmentSimpleModel = new GridGallery_Galleries_Attachment();
			$resourcesModel = $this->getModel('resources');
			$photoModel = $this->getModel('photos');
			$imageOptimizeModel = $this->getModel('imageOptimize');
			$optimizationModel = $this->getModel('optimization');
			$gallerySettings = $this->getModel('settings');

			foreach($route['data'] as $galleryId => $gallerInfo) {
				$galleryId = (int) $galleryId;
				$photoOptCount = 0;
				$newModelSize = $optimizationModel->calcGalleryCurrentSize($galleryId, $attachmentSimpleModel, $resourcesModel, $photoModel, $gallerySettings, $isOptimizePreview, $photoOptCount);

				$res = $imageOptimizeModel->insertUpdate(array(
					'gallery_id' => $galleryId,
					'can_restore' => (int) $isRestore,
					'last_optimize_date' => date('Y.m.d'),
					'service_code' => $serviceCode,
					'size' => (int)$gallerInfo['size'],
					'optimized_size' => $newModelSize,
					'photo_count' => $photoOptCount,
				));
			}
		}

		return $this->response(Rsc_Http_Response::AJAX, array(
			'success' => $isSuccess,
			'message' => $message,
		));
	}

	public function saveCdnInfoToDbAction(Rsc_Http_Request $request) {
		$route = $request->post->get("route");
		$addedGall = array();

		if(isset($route['data']) && isset($route['data']['gallery-obj']) && count($route['data']['gallery-obj'])) {
			$serviceCode = isset($route['data']['serviceCode']) ? $route['data']['serviceCode'] : null;

			foreach($route['data']['gallery-obj'] as $galleryId => $gallInfo) {
				if(isset($gallInfo['size'])) {
					$cdnModel = $this->getModel('cdn');
					$oneRecord = array(
						'gallery_id' => $galleryId,
						'last_transfer_date' => date('Y.m.d'),
						'service_code' => $serviceCode,
						'size' => $gallInfo['size'],
					);
					if($cdnModel->save($oneRecord)) {
						$oneRecord['last_transfer_date'] = date('d.m.Y');
						$addedGall[] = $oneRecord;
					}
				}
			}
		}

		return $this->response(Rsc_Http_Response::AJAX, array(
			'galleries' => $addedGall,
		));
	}

	public function rollbackRestoredImgAction(Rsc_Http_Request $request) {
		$message = $this->translate('Error occurred');
		$isSuccess = false;
		$data = isset($request->post['route']['data']) ? $request->post['route']['data'] : null;
		$photos = array();

		if($data && $data['gallery_id']) {
			$galleryId = intval($data['gallery_id']);
			$optimizeModel = $this->getModel('optimization');
			$resources = $this->getModel('resources');
			$photoModel = $this->getModel('photos');
			$imgOptimize = $this->getModel('imageOptimize');
			$currGallerySettings = $this->getModel('settings')->get($galleryId);
			$optimizeModel->restorePreviousFiles($galleryId, $resources, $photoModel, $currGallerySettings, $imgOptimize);
		}

		return $this->response(Rsc_Http_Response::AJAX, array(
			'success' => $isSuccess,
			'message' => $message,
		));
	}

	private function transferToCdnOnePhotoObj($ftpModel, $attachModel, $onePhoto, $needToDelete) {
		if(isset($_SERVER['HTTP_X_REQUEST_SCHEME'])) {
			$currServerName = $_SERVER['HTTP_X_REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
		} else {
			$currServerName = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
		}
		$ftpMainImgUrl = preg_replace('`' . $currServerName . '`', '', $onePhoto['img_url']);
		$mainPath = realpath($attachModel->replaceUrlToFilePath($onePhoto['img_url']));
		$ftpModel->uploadFileOnServer($ftpMainImgUrl, $mainPath);

		if(isset($onePhoto['preview_url'])) {
			$ftpPreviewImgUrl = preg_replace('`' . $currServerName . '`', '', $onePhoto['preview_url']);
			$previewPath = realpath($attachModel->replaceUrlToFilePath($onePhoto['preview_url']));
			$ftpModel->uploadFileOnServer($ftpPreviewImgUrl, $previewPath);
		}
	}
}