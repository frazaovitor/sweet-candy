<?php
class GridGallery_Optimization_Model_Ftp {

	private $ftpConn;
	private $host;
	private $port;
	private $defaultPort = 21;
	private $ftpUsername;
	private $ftpPassword;
	private $folderName;
	public $authError;

	function __construct(array $config) {

		$this->host = isset($config['host']) ? $config['host'] : null;
		$this->port = isset($config['port']) ? $config['port'] : null;
		$this->ftpUsername = isset($config['ftpUsername']) ? $config['ftpUsername'] : null;
		$this->ftpPassword = isset($config['ftpPassword']) ? $config['ftpPassword'] : null;
		$this->folderName = isset($config['folderName']) ? $config['folderName'] : '/';
	}

	function __destruct() {
		if($this->ftpConn) {
			ftp_close($this->ftpConn);
			$this->ftpConn = null;
		}
	}

	public function uploadFileOnServer($ftpNewFileName, $localFileName) {
		$this->connectFtp();
		// create directory on FTP-server)
		if($this->checkSubDirectoryAndCreate(dirname($ftpNewFileName))) {
			// create file
			if(!@ftp_put($this->ftpConn, rtrim($this->folderName, '/') . $ftpNewFileName, $localFileName, FTP_BINARY)) {
				throw new Exception('File not upload!');
			}
		} else {
			throw new Exception("Can't create ftp-directory!");
		}
	}

	public function checkSubDirectoryAndCreate($currFtpDir) {
		$result = false;
		$currFtpDir = trim(trim($currFtpDir), '/');
		@ftp_chdir($this->ftpConn, $this->folderName);
		if($currFtpDir != '' && $currFtpDir != '.' && $currFtpDir != '..') {
			// if not exist this directory
			if(!@ftp_chdir($this->ftpConn, $currFtpDir)) {

				$dirParts = explode('/', $currFtpDir);
				foreach($dirParts as $part) {
					if(!@ftp_chdir($this->ftpConn, $part)) {
						ftp_mkdir($this->ftpConn, $part);
						$result = ftp_chdir($this->ftpConn, $part);
					}
				}
			} else {
				$result = true;
			}
		}
		return $result;
	}

	private function connectFtp() {
		if(!$this->ftpConn = @ftp_connect($this->host, empty($this->port) ? $this->defaultPort : $this->port)) {
			throw new Exception('Can not connect to remote FTP server');
		}

		if(!@ftp_login($this->ftpConn, $this->ftpUsername, $this->ftpPassword)) {
			$this->authError = true;
			throw new Exception('Wrong username or password');
		}

		@ftp_pasv($this->ftpConn, true);

		if(!@ftp_chdir($this->ftpConn, $this->folderName)) {
			throw new Exception('Can not open directory');
		}
	}
}