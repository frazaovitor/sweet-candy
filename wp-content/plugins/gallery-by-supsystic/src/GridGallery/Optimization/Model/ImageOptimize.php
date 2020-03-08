<?php
class GridGallery_Optimization_Model_ImageOptimize extends Rsc_Mvc_Model {

	protected $table;

	public function __construct() {
		parent::__construct();
		$this->table = $this->db->prefix . 'gg_image_optimize';
	}

	public function extendGalleryImageOptimizeInfo(&$galleryList, $inMb = true) {
		if(count($galleryList)) {
			$galleryIds = array();
			foreach($galleryList as $gallObj) {
				$galleryIds[] = $gallObj->id;
			}

			$galleryIdsStr = implode(',', $galleryIds);

			$querySel = $this->getQueryBuilder()->select('gallery_id, can_restore, last_optimize_date, service_code, size, optimized_size')
				->from($this->table)
				->where('gallery_id', 'in',  $galleryIdsStr);
			$optimizeInfo = $this->db->get_results($querySel->build(), OBJECT_K);

			if(count($optimizeInfo) > 0) {
				foreach($galleryList as $key=> $gallObj) {
					if(isset($optimizeInfo[$gallObj->id])) {
						$gallObj->gallery_id = $optimizeInfo[$gallObj->id]->gallery_id;
						$gallObj->can_restore = $optimizeInfo[$gallObj->id]->can_restore;
						$gallObj->last_optimize_date = date('d.m.Y', strtotime($optimizeInfo[$gallObj->id]->last_optimize_date));
						$gallObj->service_code = $optimizeInfo[$gallObj->id]->service_code;
						$gallObj->service_name = GridGallery_Optimization_Model_Optimization::getSeviceNameByCode($gallObj->service_code);

						$gallObj->optimize_percent = GridGallery_Optimization_Model_Optimization::calcOptimizePercent(
							$optimizeInfo[$gallObj->id]->size,
							$optimizeInfo[$gallObj->id]->optimized_size
						);

						if($inMb) {
							$gallObj->size = GridGallery_Optimization_Model_Optimization::getSizeInMb($optimizeInfo[$gallObj->id]->size);
							$gallObj->optimized_size = GridGallery_Optimization_Model_Optimization::getSizeInMb($optimizeInfo[$gallObj->id]->optimized_size);
						} else {
							$gallObj->size = $optimizeInfo[$gallObj->id]->size;
							$gallObj->optimized_size = $optimizeInfo[$gallObj->id]->optimized_size;
						}
					}
				}
				return true;
			}
		}
		return false;
	}

	public function insertUpdate($assocArray) {
		if(!isset($assocArray['gallery_id'])) {
			return null;
		}

		// check for record Exists
		$querySel = $this->getQueryBuilder()->select('gallery_id')
			->from($this->table)
			->where('gallery_id', '=',  (int)$assocArray['gallery_id']);
		$optimizeRecords = $this->db->get_results($querySel->build());

		if(count($optimizeRecords) > 0) {
			// update
			$gallery_id = $assocArray['gallery_id'];
			unset($assocArray['gallery_id']);

			$queryUpdate = $this->getQueryBuilder()->update($this->table)
				->fields(array_keys($assocArray))
				->values(array_values($assocArray))
				->where('gallery_id', '=', (int) $gallery_id);

			return $this->db->query($queryUpdate->build());
		} else {
			// insert
			$queryInsert = $this->getQueryBuilder()
				->insertInto($this->table)
				->fields(array_keys($assocArray))
				->values(array_values($assocArray));

			return $this->db->query($queryInsert->build());
		}
	}

	public function removeByGalleryId($galleryId) {
		$query = $this->getQueryBuilder()->deleteFrom($this->table)
			->where('gallery_id', '=', (int) $galleryId);

		return $this->db->query($query->build());
	}

	public function getStatistic() {
		$query = "
		SELECT '1' as ind, SUM(size) as size, SUM(optimized_size) as optimized_size, SUM(photo_count) as photo_count
		FROM " . $this->table
		. " WHERE last_optimize_date = date(NOW())
		UNION ALL
		SELECT '2' as ind, SUM(size) as size, SUM(optimized_size) as optimized_size, SUM(photo_count) as photo_count
		FROM " . $this->table
		. " WHERE last_optimize_date BETWEEN date_sub(now(), INTERVAL 1 WEEK) AND date(NOW())
		UNION ALL
		SELECT '3' as ind, SUM(size) as size, SUM(optimized_size) as optimized_size, SUM(photo_count) as photo_count
		FROM " . $this->table
		. " WHERE last_optimize_date BETWEEN date_sub(now(), INTERVAL 1 MONTH) AND date(NOW())";

		$statsArr = $this->db->get_results($query, OBJECT_K);

		if(count($statsArr) > 0) {
			foreach($statsArr as $key => $elem) {
				$elem->photo_count = (int)$elem->photo_count;
				$elem->size = (int) $elem->size;
            	$elem->optimized_size = (int) $elem->optimized_size;
				$elem->size_mb = GridGallery_Optimization_Model_Optimization::getSizeInMb($elem->size);
				$elem->optimized_size_mb = GridGallery_Optimization_Model_Optimization::getSizeInMb($elem->optimized_size);
				$elem->save_mb = $elem->size_mb - $elem->optimized_size_mb;
				if($elem->size_mb != 0) {
					$elem->save_percent = 100 - round($elem->optimized_size_mb*100/$elem->size_mb, 2);
				} else {
					$elem->save_percent = '0';
				}
			}
		}
		return $statsArr;
	}

	public function checkRequirements() {
		$requirements = array();

		// check for table exists
		$query = "SHOW TABLES LIKE '" . $this->table . "'";
		$tablesList = $this->db->get_results($query, OBJECT_K);
		if(count($tablesList) == 0) {
			$requirements[] = translate('Table ' . $this->table. ' not exists! Please reactivate this plugin!');
		}

		// check minimal php version
		if(version_compare(PHP_VERSION, '5.3.0') == -1) {
			$requirements[] = translate('Minimal version of php = 5.3.0');
		}

		// check curl
		if(!function_exists('curl_version')) {
			$requirements[] = translate('Enable cUrl extension');
		}

		// check minimal curl version
		if(!function_exists('curl_version')) {
			$requirements[] = translate('Can\'t check current version of cUrl extension');
		} else {
			$curlFlag = false;
			$curlVer = curl_version();
			if(isset($curlVer['version'])) {
				if(version_compare($curlVer['version'], '7.19.0') > -1) {
					$curlFlag = true;
				}
			}

			if(!$curlFlag) {
				$requirements[] = translate('Minimal cUrl extension version 7.19.0');
			}
		}

		return (count($requirements) > 0) ? $requirements : false;
	}

	public function getInfoByGalleryId($galleryId) {
		$galleryId = (int) $galleryId;
		if($galleryId) {
			$selectQuery = $this->getQueryBuilder()
				->select('service_code')
				->from($this->table)
				->where('gallery_id', '=', $galleryId);

			$result = $this->db->get_results($selectQuery, ARRAY_A);
			if(count($result)) {
				return $result;
			}
		}
		return null;
	}
}