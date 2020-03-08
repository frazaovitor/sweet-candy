<?php

class GridGallery_Photos_Model_Position extends GridGallery_Core_BaseModel
{

    const SCOPE_FOLDER = 'folder';
    const SCOPE_GALLERY = 'gallery';
    const SCOPE_MAIN = 'main';

    /**
     * @var string
     */
    protected $table;

    /**
     * Constructor.
     */
    public function __construct($debugEnabled = false)
    {
        parent::__construct();

        $this->debugEnabled = (bool)$debugEnabled;
        $this->table = $this->db->prefix . 'gg_photos_pos';
    }

    /**
     * Updates the position
     * @param  array $data
     * @return bool
     */
    public function update(array $data)
    {
        if (!isset($data['elements']) || count($data['elements']) < 1) {
            return false;
        }

        $this->clearScope($data['scope'], $data['scope_id']);

        foreach ($data['elements'] as $element) {
            $this->updatePosition(array(
                'photo_id' => (int)$element['photo_id'],
                'position' => (int)$element['position'],
                'scope_id' => (int)$data['scope_id'],
                'scope' => $data['scope'],
            ));
        }

        return true;
    }

    /**
     * Updates position for the single row.
     * @param  array $row
     * @return bool
     */
    public function updatePosition(array $row)
    {
        $query = $this->getQueryBuilder()
            ->insertInto($this->table)
            ->fields(array_keys($row))
            ->values(array_values($row));

        if (!$this->db->query($query->build())) {
            return false;
        }

        return true;
    }

    /**
     * Clears the positions in the selected scope.
     * @param string $scope Scope type.
     * @param int $id Scope ID.
     */
    public function clearScope($scope = self::SCOPE_MAIN, $id = 0)
    {
        $query = $this->getQueryBuilder()
            ->deleteFrom($this->table)
            ->where('scope', '=', $scope)
            ->andWhere('scope_id', '=', (int)$id);

        $this->db->query($query->build());
    }

    /**
     * Returns the positions of the element in the specific scope.
     * @param  int $id Element Id.
     * @param  string $scope Scope type.
     * @param  int $scopeId Scope Id.
     * @return int
     */
    public function getPosition($id, $scope = self::SCOPE_MAIN, $scopeId = 0)
    {
        $query = $this->getQueryBuilder()
            ->select('position')
            ->from($this->table)
            ->where('scope', '=', $scope)
            ->andWhere('scope_id', '=', (int)$scopeId)
            ->andWhere('photo_id', '=', (int)$id);

        if (null === $row = $this->db->get_row($query->build())) {
            return 0;
        }

        return $row->position;
    }

    public function getPositions($scope = self::SCOPE_MAIN, $scopeId = 0)
    {
        $query = $this->getQueryBuilder()
            ->select('position, photo_id')
            ->from($this->table)
            ->where('scope', '=', $scope)
            ->andWhere('scope_id', '=', (int)$scopeId);

        if (null === $row = $this->db->get_results($query->build())) {
            return 0;
        }

        return $row;
    }

    /**
     * get the current position in scope
     * @param string $scope
     * @param int $scopeId
     * @return int current position in scope
     */
    public function getCurrentPosition($scope = self::SCOPE_MAIN, $scopeId = 0){
        $query = $this->getQueryBuilder()
            ->select('max(position) as position')
            ->from($this->table)
            ->where('scope','=',$scope)
            ->andWhere('scope_id', '=', (int)$scopeId);

        if (null === $row = $this->db->get_row($query->build())) {
            return 0;
        }

        return (int)$row->position + 1;
    }

    /**
     * Extends the photo object with the 'position' property.
     * @param  array|object $photo Photo object.
     * @param  string $scope Scope type.
     * @param  int $scopeId Scope Id.
     * @return array|object
     */
    public function setPosition($photo, $scope = self::SCOPE_MAIN, $scopeId = 0)
    {
        $isArray = false;

        if (is_array($photo)) {
            $photo = (object)$photo;
            $photos = $this->getPositions($scope, $scopeId);
            $isArray = true;

            return $photos;
        } else {
            $photo->position = $this->getPosition($photo->id, $scope, $scopeId);
        }

        return $isArray ? (array)$photo : $photo;
    }

    /**
     * Sorts an array of the photos by thier position.
     * @param  array $photos An array of the photos.
     * @return array
     */
    /**
     * Sorts an array of the photos by thier position.
     * @param  array $photos An array of the photos.
     * @return array
     */
    public function sort(array $photos, $sort = null)
    {
        $isObjectCollection = false;
        $position = array();
        $sorted = array();

        if (empty($photos)) {
            return array();
        }

        if($sort == null){
            $sort = array(
                'sortby' => 'position',
                'sortto' => 'asc'
            );
        }

        // If it is collection of the StdClass, them we are convert it to array.
        if (is_object($photos[0])) {
            $isObjectCollection = true;
            $photos = array_map(array($this, 'toArray'), $photos);
        }

        // Sortto flag.
        if($sort['sortto'] == 'asc' || empty($sort['sortto'])){
            $sort_flag = SORT_ASC;
        } else {
            $sort_flag = SORT_DESC;
        }

        // If $photos is collection of the objects, then conver rows to the objs.
        if ($isObjectCollection) {
            return array_map(array($this, 'toObject'), $this->sortBy($photos, $sort['sortby'], $sort_flag));
        }

        // ... or simply return array
        return $photos;
    }

    /**
     * Sorted by photos
     * @param array $photos 
     * @param string $sortby Tag when be sorted ('title','position'...)
     * @param flag $flag Sorted flag (ASC, DESC)
     * @return array $photos
     */
    private function sortBy(array $photos, $sortby, $flag)
    {
        switch ($sortby) {
            //По дате добавления
            case 'adate':
                $date = array();
                foreach($photos as $key => $row){
                    $date[$key] = $row['timestamp'];
                }
                array_multisort($date, $flag, $photos);
            break;

            //По дате создания
            case 'date':
                $date = array();
                foreach($photos as $key => $row){
                    $date[$key] = $row['attachment']['date'];
                }
                array_multisort($date, $flag, $photos);
            break;

            //По размеру
            case 'size':
                $date = array();
                foreach($photos as $key => $row){
                    $date[$key] = $row['attachment']['filesizeInBytes'];
                }
                array_multisort($date, $flag, $photos);
            break;

            //По имени
            case 'name':
                $title = array();
                foreach($photos as $key => $row){
                    $title[$key] = $row['attachment']['name'];
                }
                array_multisort($title, $flag, $photos);
            break;

            //По имени файла
            case 'filename':
	            $filenames = array();
	            foreach($photos as $key => $row){
		            $filenames[$key] = $row['attachment']['filename'];
	            }
	            array_multisort($filenames, $flag,SORT_NATURAL|SORT_FLAG_CASE, $photos);
            break;

            //По тегам
            case 'tags':
                $date = array();
                foreach($photos as $key => $row){
                    if(isset($row['tags'])){
                        $date[$key] = $row['tags'];
                    } else {
                        $date[$key] = $row['position'];
                    }
                }
                array_multisort($date, $flag, $photos);
            break;

			// В случайном порядке
			case 'randomly':
				$countPhoto = count($photos);
				for($ind1 = 0; $ind1 < $countPhoto; $ind1++) {
					$rndSorArr[] = rand()%500;
				}
				array_multisort($rndSorArr, $photos);
				break;
            
            //По позиции
            default:
                $position = array();
                foreach ($photos as $key => $row) {
                    $position[$key] = $row['position'];
                }
                array_multisort($position, $flag, $photos);
            break;
        }

        return $photos;
    }

    /**
     * Casts the element to array.
     * @param  object $element
     * @return array
     */
    public function toArray($element)
    {
        return (array)$element;
    }

    /**
     * Casts the element to object
     * @param  array $element
     * @return object
     */
    public function toObject($element)
    {
        return (object)$element;
    }

	public function getRowsByScopeId($id) {
		$query = $this->getQueryBuilder()
			->select('photo_id', 'scope', 'position')
			->from($this->table)
			->where('scope_id', '=', (int)$id);
		$res = $this->db->get_results($query->build());
		return $res;
	}

    public function cloneByScopeId($oldId, $newId) {
		$scopes = $this->getRowsByScopeId($oldId);
		if(count($scopes)) {
			$query = $this->getQueryBuilder()->insertInto($this->table)
				->fields('photo_id', 'scope', 'scope_id', 'position');
			foreach($scopes as $rowValue) {
				$query = $query->values($rowValue->photo_id, $rowValue->scope, $newId, $rowValue->position);
			}
			$this->db->query($query);
		}
		return true;
    }

	public function insertPosition(array $rowArr, $scope_id, $scope) {
		$query = $this->getQueryBuilder()
			->insertInto($this->table)
			->fields('photo_id', 'position', 'scope_id', 'scope');

		if(count($rowArr)) {
			foreach($rowArr as $keyRow => $valueRow) {
				$query = $query->values($valueRow['photo_id'], $valueRow['position'], $scope_id, $scope);
			}
		}

		if (!$this->db->query($query->build())) {
			return false;
		}

		return true;
	}

	public function replacePosition(array $data) {
		if (!isset($data['elements']) || count($data['elements']) < 1) {
			return false;
		}

		$removeParams = array();
		$insertParams = array();
		foreach ($data['elements'] as $element) {
			$insertParams[] = array(
				'photo_id' => (int)$element['photo_id'],
				'position' => (int)$element['position'],
			);
			$removeParams[] = (int)$element['photo_id'];
		}

		$this->removeByPhotoIds($data['scope'], $data['scope_id'], $removeParams);
		$this->insertPosition($insertParams, (int)$data['scope_id'], $data['scope']);

		return true;
	}

	public function removeByPhotoIds($scope = self::SCOPE_MAIN, $scope_id, array $photoIds) {
		$query = $this->getQueryBuilder()
			->deleteFrom($this->table)
			->where('scope', '=', $scope)
			->andWhere('scope_id', '=', $scope_id)
			->andWhere('photo_id', 'IN', $photoIds);

		$this->db->query($query->build());
	}

	public function cleanAndCreate($galleryId, $photoRows, $sortTo = 1) {
		$this->clearScope('gallery', $galleryId);
		$position = 0;
		$count = count($photoRows);
		if($count) {
			foreach ($photoRows as $element) {
				$insertParams[] = array(
					'photo_id' => (int)$element['resource_id'],
					'position' => ($sortTo == 1) ? $position : ($count - $position - 1),
				);
				$position++;
			}
			$this->insertPosition($insertParams, (int)$galleryId, 'gallery');
		}
	}
}
