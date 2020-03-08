<?php


class Rsc_Menu_Item
{

    /**
     * @var string
     */
    protected $parentSlug;

    /**
     * @var string
     */
    protected $pageTitle;

    /**
     * @var string
     */
    protected $menuTitle;

    /**
     * @var string
     */
    protected $capability;

    /**
     * @var string
     */
    protected $menuSlug;

    /**
     * @var Rsc_Resolver
     */
    protected $resolver;

    /**
     * @var string
     */
    protected $moduleName;
	
	/**
     * @var int
     */
    protected $sortOrder = 0;

    /**
     * Constructor
     * @param string $parentSlug
     * @param Rsc_Resolver $resolver
     */
    public function __construct($parentSlug, Rsc_Resolver $resolver)
    {
        $this->parentSlug = $parentSlug;
        $this->resolver = $resolver;
    }

    /**
     * Set the capability
     * @param string $capability The capability required for this menu to be displayed to the user
     * @return Rsc_Menu_Item
     */
    public function setCapability($capability)
    {
        $this->capability = $capability;
        return $this;
    }

    /**
     * Returns the capability
     * @return string
     */
    public function getCapability()
    {
        return $this->capability;
    }

    /**
     * Set the menu slug
     * @param string $menuSlug The slug name to refer to this menu by
     * @return Rsc_Menu_Item
     */
    public function setMenuSlug($menuSlug)
    {
        $this->menuSlug = $menuSlug;
        return $this;
    }

    /**
     * Returns the menu slug
     * @return string
     */
    public function getMenuSlug()
    {
        return $this->menuSlug;
    }

    /**
     * Set the menu title
     * @param string $menuTitle The text to be used for the menu
     * @return Rsc_Menu_Item
     */
    public function setMenuTitle($menuTitle)
    {
        $this->menuTitle = $menuTitle;
        return $this;
    }

    /**
     * Returns the menu title
     * @return string
     */
    public function getMenuTitle()
    {
        return $this->menuTitle;
    }

    /**
     * Set the page title
     * @param string $pageTitle The text to be displayed in the title tags of the page when the menu is selected
     * @return Rsc_Menu_Item
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }

    /**
     * Returns the page title
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Sets the module name
     * @param string $moduleName
     * @return Rsc_Menu_Item
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;
        return $this;
    }

    /**
     * Returns the module name
     * @return string
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }
	
	public function setSortOrder($sortOrder) {
		$this->sortOrder = $sortOrder;
		return $this;
	}
	public function getSortOrder() {
		return $this->sortOrder;
	}

    /**
     * Register submenu item
     */
    public function register()
    {
        $parameters = array(
            $this->parentSlug,
            $this->pageTitle,
            $this->menuTitle,
            $this->capability,
            $this->menuSlug,
            array($this->resolver, 'resolve'),
        );

        call_user_func_array('add_submenu_page', $parameters);
        $this->resolver->setRoute($this->menuSlug, $this->moduleName);
    }
}