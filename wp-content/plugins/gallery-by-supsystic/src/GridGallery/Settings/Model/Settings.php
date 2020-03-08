<?php

/**
 * Class GridGallery_Settings_Model_Settings
 *
 * @package GridGallery\Settings\Model
 * @author Artur Kovalevsky
 */
class GridGallery_Settings_Model_Settings extends GridGallery_Core_BaseModel
{

    /**
     * @var GridGallery_Settings_Registry
     */
    private $registry;

    /**
     * Sets the Settings Registry object
     *
     * @param \GridGallery_Settings_Registry $registry
     * @return GridGallery_Settings_Model_Settings
     */
    public function setRegistry($registry)
    {
        $this->registry = $registry;
        return $this;
    }

    public function save(Rsc_Http_Request $request)
    {
        foreach ($request->post as $field => $value) {
            $this->registry->set($field, $value);
        }
    }
} 