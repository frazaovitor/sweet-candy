<?php
class GridGallery_Galleries_Model_Pagination extends GridGallery_Core_BaseModel {

	public $nextLinkKey;
	public $prevLinkKey;
	public $firstLinkKey;
	public $lastLinkKey;

	public $pageParam = 'gp';
	public $pageSizeParam = 'gpp';
	
	public $totalCount = 0;
	public $defaultPageSize = 100;

	private $_pageSize;
	private $_page;

	public function __construct() {
	}

	public function onInit() {
		$this->nextLinkKey = 'next';
		$this->prevLinkKey = 'prev';
		$this->firstLinkKey = 'first';
		$this->lastLinkKey = 'last';
	}

	public function initParams(array $params) {
		if(count($params)) {
			foreach($params as $keyParam => $valParam) {
				if(property_exists($this, $keyParam)) {
					$this->$keyParam = $valParam;
				}
			}
		}
	}

	public function getPageCount() {
		$pageSize = $this->getPageSize();
		if ($pageSize < 1) {
			return $this->totalCount > 0 ? 1 : 0;
		}
		$totalCount = $this->totalCount < 0 ? 0 : (int) $this->totalCount;
		return (int) (($totalCount + $pageSize - 1) / $pageSize);
	}

	public function getPage() {
		if ($this->_page === null) {
			$page = (int) $this->getQueryParam($this->pageParam, 0);
			$this->setPage($page, true);
		}
		return $this->_page;
	}

	public function getPageFromParam() {
		return (int) $this->getQueryParam($this->pageParam, 1);
	}

	public function setPage($value, $validatePage = false) {
		if ($value === null) {
			$this->_page = null;
		} else {
			$value = (int) $value;
			if ($validatePage) {
				$pageCount = $this->getPageCount();
				if ($value > $pageCount) {
					$value = $pageCount;
				}
			}
			if ($value < 0) {
				$value = 0;
			}
			$this->_page = $value;
		}
	}

	public function getPageSize() {
		if ($this->_pageSize === null) {
			$pageSize = (int) $this->getQueryParam($this->pageSizeParam, $this->defaultPageSize);
			$this->_pageSize = $pageSize;
		}
		return $this->_pageSize;
	}

	public function createUrl($page, $pageSize = null) {
		$page = (int) $page;
		$pageSize = (int) $pageSize;
		$params = $this->getAllParams();
		if ($page > 0) {
			$params[$this->pageParam] = $page + 1;
		} else {
			unset($params[$this->pageParam]);
		}
		if ($pageSize <= 0) {
			$pageSize = $this->getPageSize();
		}
		if ($pageSize != $this->defaultPageSize) {
			$params[$this->pageSizeParam] = $pageSize;
		} else {
			unset($params[$this->pageSizeParam]);
		}
		$currentUrl = strtok($_SERVER["REQUEST_URI"], '?');
		$httpParams = http_build_query($params);
		if(strlen($httpParams)) {
			$httpParams = '?' . $httpParams;
		}
		return $currentUrl . $httpParams;
	}

	public function getOffset() {
		$pageSize = $this->getPageSize();
		return $pageSize < 1 ? 0 : $this->getPage() * $pageSize;
	}

	public function getLimit() {
		$pageSize = $this->getPageSize();
		return $pageSize < 1 ? -1 : $pageSize;
	}

	public function getLinks() {
		$currentPage = $this->getPage();
		$pageCount = $this->getPageCount();

		$links = array();

		if ($currentPage > 0) {
			$currentPage--;
			$links[$this->firstLinkKey] = $this->createUrl(0, null);
			$links[$this->prevLinkKey] = $this->createUrl($currentPage - 1, null);
		}
		$links['current'] = $this->createUrl($currentPage, null);
		if ($currentPage < $pageCount - 1) {
			$links[$this->nextLinkKey] = $this->createUrl($currentPage + 1, null);
			$links[$this->lastLinkKey] = $this->createUrl($pageCount - 1, null);
		}
		return $links;
	}

	protected function getAllParams() {
		return $_REQUEST;
	}

	protected function getQueryParam($name, $defaultValue = null) {
		$params = $this->getAllParams();
		return isset($params[$name]) && is_scalar($params[$name]) ? $params[$name] : $defaultValue;
	}

	/**
	 * @param int $sideCount - link count, that showing at left and right of current page
	 * @return array
	 */
	public function getAllLinks($sideCount = 1) {
		$resLinks = array();
		$links = $this->getLinks();
		$currentPage = $this->getPage();
		$pageCount = $this->getPageCount();

		$resLinks['info']['currentPage'] = ($currentPage == 0) ? 1 : $currentPage;
		$resLinks['info']['total'] = $this->totalCount;
		$resLinks['info']['currPageForJs'] = ($currentPage > 0) ? $currentPage - 1 : $currentPage;
		$resLinks['info']['pageCount'] = $pageCount;
		if(isset($links['prev'], $links['first'])) {
			$ind1 = $currentPage - $sideCount;
			if($ind1 < 0) {
				$ind1 = 0;
			}
			$resLinks['info']['first'] = $links['first'];
			$resLinks['info']['prev'] = $links['prev'];
			while($ind1 < $currentPage) {
				$resLinks[$ind1] = $this->createUrl($ind1-1);
				$ind1++;
			}
		}

		if(isset($links['current'])) {
			$resLinks[$currentPage] = $this->createUrl($currentPage);
		}

		if(isset($links['next'], $links['last'])) {
			$ind1 = $currentPage + 1;

			$nextMaxPage = $ind1 + $sideCount;
			if($nextMaxPage > $pageCount) {
				$nextMaxPage = $pageCount;
			}
			while($ind1 <= $nextMaxPage) {
				$resLinks[$ind1] = $this->createUrl($ind1-1);
				$ind1++;
			}
			$resLinks['info']['next'] = $links['next'];
			$resLinks['info']['last'] = $links['last'];
		}
		
		// prepare per page list
		$resLinks['info']['perPageArr'] = $this->getPerPageSelectorList();
		// current selected value
		$resLinks['info']['perPage'] = $this->getPerPageParam(); 

		return $resLinks;
	}

	public function getPerPageSelectorList() {
		return array(
//			'1' => '1',
//			'5' => '5',
			'10' => 10,
			'20' => 20,
			'50' => 50,
			'100' => 100,
			'500' => 500,
			'all' => translate('All'),
		);
	}
	public function getPerPageParam() {
		$selectorList = $this->getPerPageSelectorList();
		// default value
		$perPage = $this->defaultPageSize;
		if(isset($_REQUEST['gpp'])) {
			$tempPerPage = $_REQUEST['gpp'];
			if(in_array($tempPerPage, array_keys($selectorList))) {
				$perPage = $tempPerPage;
			}
		}
		return $perPage;
	}
}