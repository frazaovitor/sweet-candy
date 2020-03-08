<?php
class GridGallery_Membership_Model_Membership extends Rsc_Mvc_Model {

	protected $table;
	protected $memberShipClassName;

	public function __construct() {
		parent::__construct();
		$this->table = $this->db->prefix . 'gg_membership_presets';
		$this->memberShipClassName = 'SupsysticMembership';
	}

	public function isPluginActive() {
		$tableExistsQuery =  "SHOW TABLES LIKE '" . $this->table . "'";
		$results = $this->db->get_results($tableExistsQuery);

		if(count($results) && class_exists($this->memberShipClassName)) {
			return true;
		}
		return false;
	}

	public function getPluginInstallUrl() {
		return add_query_arg(
			array(
				's' => 'Membership by Supsystic',
				'tab' => 'search',
				'type' => 'term',
			),
			admin_url( 'plugin-install.php' )
		);
	}

	public function getPluginInstallWpUrl() {
		return 'https://wordpress.org/plugins/membership-by-supsystic/';
	}

	public function updateRow($params) {
		if(isset($params['gallery_id']) && isset($params['allow_use'])) {
			$allowUse = (int)$params['allow_use'];
			$galleryId = (int)$params['gallery_id'];

			$query = "INSERT INTO `" . $this->table . "`(`gallery_id`, `allow_use`)"
				. " VALUES (" . $galleryId . ", " . $allowUse . ") "
				. "ON DUPLICATE KEY UPDATE `allow_use`=" . $allowUse;

			$res = $this->db->query($query);
			return $res;
		}
		return false;
	}

	public function removeRowByGalleryId($galleryId) {
		$query = "DELETE FROM " . $this->table
			. " WHERE `gallery_id`=" . (int) $galleryId;

		$res = $this->db->query($query);
		return $res;
	}

	/**
	 * prepare photo images from simple image file to gallery attachment (not all gallery functions supporting)
	 * @param array $simpleImage
	 */
	public function getGalleryAttachmenEmuledImage(array $simpleImage) {

		$attachment = array(
			'id' => null,
			'title' => '',
			'filename' => '',
			'url' => $simpleImage['url'],
			'link' => '',
			'alt' => '',
			'author' => 0,
			'description' => '',
			'caption' => '',
			'name' => '',
			'status' => 'inherit',
			'uploadedTo' => 0,
			'date' => 0,
			'modified' => 0,
			'menuOrder' => 0,
			'mime' => 'image/jpeg',
			'type' => 'image',
			'subtype' => 'jpeg',
			'icon' => '',
			'dateFormatted' => '',
			'nonces' => array (),
			'editLink' => '',
			'meta' => null,
			'authorName' => '',
			'filesizeInBytes' => 0,
			'filesizeHumanReadable' => '0 KB',
			'height' => $simpleImage['height'],
			'width' => $simpleImage['width'],
			'orientation' => 'landscape',
			'sizes' => array(
				'thumbnail' => array(
					'height' => $simpleImage['height'],
					'width' => $simpleImage['width'],
					'url' => $simpleImage['url'],	//http://sst-w1.loc/wp-content/uploads/2016/11/roses7-1024x640.jpg
					'orientation' => 'landscape',
				),
				'medium' => array(
					'url' => $simpleImage['url'],
					'height' => $simpleImage['height'],
					'width' => $simpleImage['width'],
					'orientation' => 'landscape',
				),
				'large' => array(
					'url' => $simpleImage['url'],
					'height' => $simpleImage['height'],
					'width' => $simpleImage['width'],
					'orientation' => 'landscape',
				),
				'full' => array(
					'url' => $simpleImage['url'],
					'height' => $simpleImage['height'],
					'width' => $simpleImage['width'],
					'orientation' => 'landscape',
				),
			),
			'external_link' => null,
			'target' => '_self',
			'video' => null,
			'linkedImages' => '',
			'hoverCaptionImage' => null,
			'rel' => null,
			'captionEffect' => '',
			'cropPosition' => 'center-center',
			'isNotRealAttachment' => 1,
		);

		$attachmentImageEmulator = new stdClass();
		$attachmentImageEmulator->id = null;
		$attachmentImageEmulator->folder_id = 0;
        $attachmentImageEmulator->album_id = 0;
        $attachmentImageEmulator->attachment_id = null;
        $attachmentImageEmulator->position = 9000;
        $attachmentImageEmulator->timestamp = null;
        $attachmentImageEmulator->attachment = $attachment;
		$attachmentImageEmulator->is_used = 1;
		$attachmentImageEmulator->used_times = 1;
		$attachmentImageEmulator->tags = array();
		
		return $attachmentImageEmulator;
	}

	public function getByGalleryId($galleryId) {
		$query = $this->getQueryBuilder()->select('allow_use')
			->from($this->table)
			->where('gallery_id', '=', (int) $galleryId);
		$res = $this->db->get_results($query->build(), ARRAY_A);
		return $res;
	}

	public function cloneByGalleryId($galleryId, $newGalleryId) {
		$membershipItems = $this->getByGalleryId($galleryId);
		if(count($membershipItems)) {
			foreach($membershipItems as $memberValue) {
				$this->updateRow(array(
					'gallery_id' => $newGalleryId,
					'allow_use' => $memberValue['allow_use'],
				));
			}
		}
		return true;
	}
}
