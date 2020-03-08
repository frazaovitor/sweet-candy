<?php

class GridGallery_Optimization_Model_Encrypt {

	private $_CIPHER = null;	//MCRYPT_RIJNDAEL_128; // Rijndael-128 is AES
	private $_MODE = null;	//MCRYPT_MODE_CBC;

	public function encrypt($pureString, $encryptionKey = '') {
		if(empty($encryptionKey))
			$encryptionKey = $this->getEncriptKey();
		if(function_exists('mcrypt_encrypt')) {
			$this->initCript();
			$encryptionKey = substr($encryptionKey, 0, 16);
			$ivSize = mcrypt_get_iv_size($this->_CIPHER, $this->_MODE);
			$iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
			$ciphertext = mcrypt_encrypt($this->_CIPHER, $encryptionKey, $pureString, $this->_MODE, $iv);
			return base64_encode($iv. $ciphertext);
		} else {
			return base64_encode($pureString);
		}
	}
	public function decrypt($encryptedString, $encryptionKey = '') {
		if(empty($encryptionKey))
			$encryptionKey = $this->getEncriptKey();
		if(function_exists('mcrypt_encrypt')) {
			$this->initCript();
			$encryptionKey = substr($encryptionKey, 0, 16);
			$ciphertext = base64_decode($encryptedString);
			$ivSize = mcrypt_get_iv_size($this->_CIPHER, $this->_MODE);
			if (strlen($ciphertext) < $ivSize) {
				return false;
			}
			$iv = substr($ciphertext, 0, $ivSize);
			$ciphertext = substr($ciphertext, $ivSize);
			$plaintext = mcrypt_decrypt($this->_CIPHER, $encryptionKey, $ciphertext, $this->_MODE, $iv);
			return rtrim($plaintext, "\0");
		} else {
			$decryptedString = base64_decode($encryptedString);
			return $decryptedString;
		}
	}

	private function initCript() {
		if(defined('MCRYPT_RIJNDAEL_128')) {
			$this->_CIPHER = MCRYPT_RIJNDAEL_128; // Rijndael-128 is AES
		}
		if(defined('MCRYPT_MODE_CBC')) {
			$this->_MODE = MCRYPT_MODE_CBC;
		}
	}

	private function getEncriptKey() {
		$authKey = AUTH_KEY;
		if(strlen($authKey) < 16) {
			for($i = strlen($authKey); $i < 16; $i++) {
				$authKey .= '1';
			}
		}
		return $authKey;
	}
}