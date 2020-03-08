<?php
class GridGallery_Optimization_Model_Cdn extends Rsc_Mvc_Model {

	protected $table;

	public static function getServiceOptionName() {
		return 'sgg_cdn_service_settings';
	}

	public function __construct() {
		parent::__construct();
		$this->table = $this->db->prefix . 'gg_cdn';
	}

	// check only table exist
	public function checkRequirements() {
		$requirements = array();

		$queryCdnTable = "SHOW TABLES LIKE '" . $this->table . "'";
		$tablesCdnList = $this->db->get_results($queryCdnTable, OBJECT_K);
		if(count($tablesCdnList) == 0) {
			$requirements[] = translate('Table ' . $this->table. ' not exists! Please reactivate this plugin!');
		}
		return (count($requirements) > 0) ? $requirements : false;
	}

	public function getCurrentServerName() {
		return $_SERVER['HTTP_HOST'];
	}

	public function getServiceSettings() {
		$imgCdnSett = @unserialize(get_option(self::getServiceOptionName(), null));

		// reset invalid configuration
		if(empty($imgCdnSett['current']) || empty($imgCdnSett['setting']) || empty($imgCdnSett['setting'][$imgCdnSett['current']])) {
			$imgCdnSett = array(
				'current' => 'keycdn',
				'setting' => array(
					'keycdn' => array(
						'zone_name' => $this->getCurrentServerName(),
						// 'u_name' => null,
						// 'u_pass' => null,
						// 'base_ftp_path' => null
					)
				)
			);
		}
		return $imgCdnSett;
	}

	public static function saveServiceSettings($settings) {
		$prepareSett = serialize($settings);
		if($prepareSett) {
			update_option(self::getServiceOptionName(), $prepareSett);
			return true;
		}
		return false;
	}

	public static function getTransferServiceNameByCode($code) {
		$name = null;
		if($code == 'keycdn') {
			$name = 'KeyCDN';
		}
		return $name;
	}

	public function extendGalleryList(&$galleryList) {
		if(count($galleryList)) {

			foreach($galleryList as $gallObj) {
				$galleryIds[] = $gallObj->id;
			}

			$galleryIdsStr = implode(',', $galleryIds);
			$querySel = $this->getQueryBuilder()->select('gallery_id, last_transfer_date, service_code, size')
				->from($this->table)
				->where('gallery_id', 'in',  $galleryIdsStr);
			$cdnInfo = $this->db->get_results($querySel->build(), OBJECT_K);

			if(count($cdnInfo) > 0) {
				foreach($galleryList as $key => $gallObj) {
					if(isset($cdnInfo[$gallObj->id])) {
						$gallObj->cdn_last_transfer_date = date('d.m.Y', strtotime($cdnInfo[$gallObj->id]->last_transfer_date));
						$gallObj->cdn_service_code = $cdnInfo[$gallObj->id]->service_code;
						$gallObj->cdn_service_name = self::getTransferServiceNameByCode($cdnInfo[$gallObj->id]->service_code);
						$gallObj->cdn_size = number_format($cdnInfo[$gallObj->id]->size / 1048576, 2);
					}
				}
				return true;
			}
		}
		return false;
	}

	public function save($params) {
		if(isset($params['gallery_id']) && isset($params['last_transfer_date']) && isset($params['service_code']) && isset($params['size'])) {

			// check for record Exists
			$querySel = $this->getQueryBuilder()->select('gallery_id')
				->from($this->table)
				->where('gallery_id', '=',  (int)$params['gallery_id']);
			$cdnRecords = $this->db->get_results($querySel->build());

			if(count($cdnRecords) > 0) {
				// update
				$gallery_id = $params['gallery_id'];
				unset($params['gallery_id']);

				$queryUpdate = $this->getQueryBuilder()->update($this->table)
					->fields(array_keys($params))
					->values(array_values($params))
					->where('gallery_id', '=', (int) $gallery_id);

				$res = $this->db->query($queryUpdate->build());
				return true;
			} else {
				// insert
				$queryInsert = $this->getQueryBuilder()
					->insertInto($this->table)
					->fields(array_keys($params))
					->values(array_values($params));

				return $this->db->query($queryInsert->build());
			}
		}
		return false;
	}

	public function isGalleryTransfer($galleryId) {
		// check for record Exists
		$querySel = $this->getQueryBuilder()->select('gallery_id')
			->from($this->table)
			->where('gallery_id', '=',  (int)$galleryId);
		$records = $this->db->get_results($querySel->build());
		return (count($records)) ? true : false;
	}

	public function getServiceCodeByGalleryId($galleryId) {
		$querySel = $this->getQueryBuilder()
			->select('service_code')
			->from($this->table)
			->where('gallery_id', '=',  (int)$galleryId);
		$records = $this->db->get_results($querySel->build(), ARRAY_A);
		if(count($records)) {
			return $records;
		}
		return null;
	}
}