<?php
class GridGallery_Promo_Model_Promo extends Rsc_Mvc_Model {
	private $_bigCli = null;
	public function saveDeactivateData( $d ) {
		$deactivateParams = array();
		$reasonsLabels = array(
			'not_working' => 'Not working',
			'found_better' => 'Found better',
			'not_need' => 'Not need',
			'temporary' => 'Temporary',
			'other' => 'Other',
		);
		$deactivateParams['Reason'] = isset($d['deactivate_reason']) && $d['deactivate_reason'] 
			? $reasonsLabels[ $d['deactivate_reason'] ]
			: 'No reason';
		if(isset($d['deactivate_reason']) && $d['deactivate_reason']) {
			switch( $d['deactivate_reason'] ) {
				case 'found_better':
					$deactivateParams['Better plugin'] = $d['better_plugin'];
					break;
				case 'other':
					$deactivateParams['Other'] = $d['other'];
					break;
			}
		}
		$this->bigStatAdd('Deactivated', $deactivateParams);
		$startUsage = (int) get_option('sgg_plug_welcome_show');
		if($startUsage) {
			$usedTime = time() - $startUsage;
			$this->bigStatAdd('Used Time', array(
				'Seconds' => $usedTime, 
				'Hours' => round($usedTime / 60 / 60), 
				'Days' => round($usedTime / 60 / 60 / 24)
			));
		}
		return true;
	}
	private function _getBigStatClient() {
		if(!$this->_bigCli) {
			if(!class_exists('Mixpanel')) {
				require_once('classes/lib/Mixpanel.php');
			}
			if(!class_exists('Mixpanel'))
				return;	// Something going wrong
			$opts = array();
			if(!function_exists('curl_init')) {
				$opts['consumer'] = 'socket';
			}
			if(class_exists('Mixpanel')) {
				$this->_bigCli = Mixpanel::getInstance("6fe8d87bb7308ab9accf8ac8c04ac962", $opts);
			}
		}
		return $this->_bigCli;
	}
	public function bigStatAdd( $key, $properties = array() ) {
		if(function_exists('json_encode')) {
			$this->_getBigStatClient();
			if($this->_bigCli) {
				$this->_bigCli->track( $key, $properties );
			}
		}
	}
	/*public function bigStatAddCheck( $key, $properties = array() ) {
		$canSend = (int) framePps::_()->getModule('options')->get('send_stats');
		if( $canSend ) {
			$this->bigStatAdd( $key, $properties );
		}
	}*/
}
