<?php

/**
 * Class GridGallery_Galleries_Model_SocialSharing
 * Provides the logic to work with the social share plugin
 *
 * @author Andrey Varenyk
 */
class GridGallery_Galleries_Model_SocialSharing extends GridGallery_Core_BaseModel
{

	private $socialSharingClass;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->socialSharingClass = 'SupsysticSocialSharing';
	}

	/**
	 * Check if Social Share plugin is installed
	 * @return true if Social Share plugin is installed and activated and false otherwise
	 */
	public function isPluginInstalled(){
		return class_exists($this->socialSharingClass);
	}

	/**
	 * Get list of social share projects
	 * @return array of pairs where key is project id and value is project title
	 */
	public function getProjectsList(){
		return apply_filters('sss_get_projects_list',array());
	}

	public function getProjectNetworks($id){
	    return apply_filters('sss_get_networks', $id);
    }
}