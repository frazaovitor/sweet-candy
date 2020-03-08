<?php


class Rsc_Menu_Page
{

    /**
     * @var Rsc_Resolver
     */
    protected $resolver;

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
     * @var string
     */
    protected $iconUrl;

    /**
     * @var int|string
     */
    protected $position;

    /**
     * @var array
     */
    protected $submenu;

    public function __construct(Rsc_Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Set the capability
     * @param string $capability The capability required for this menu to be displayed to the user
     * @return Rsc_Menu_Page
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
		return apply_filters(sprintf('%s_menu_capability', $this->resolver->getEnvironment()->getConfig()->get('plugin_name')), $this->capability);
    }

    /**
     * Set the icon url
     * @param string $iconUrl The icon for this menu
     * @return Rsc_Menu_Page
     */
    public function setIconUrl($iconUrl)
    {
        $this->iconUrl = $iconUrl;
        return $this;
    }

    /**
     * Returns the icon url
     * @return string
     */
    public function getIconUrl()
    {
        return $this->iconUrl;
    }

    /**
     * Set the slug name
     * @param string $menuSlug The slug name to refer to this menu by
     * @return Rsc_Menu_Page
     */
    public function setMenuSlug($menuSlug)
    {
        $this->menuSlug = $menuSlug;
        return $this;
    }

    /**
     * Returns the slug name
     * @return string
     */
    public function getMenuSlug()
    {
        return $this->menuSlug;
    }

    /**
     * Set the menu title
     * @param string $menuTitle The on-screen name text for the menu
     * @return Rsc_Menu_Page
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
     * @return Rsc_Menu_Page
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }

    /**
     * Get the page title
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Set the position
     * @param int|string $position The position in the menu order this menu should appear
     * @return Rsc_Menu_Page
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get the position
     * @return int|string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Create an instance of the submenu item class
     * @return Rsc_Menu_Item
     */
    public function createSubmenuItem()
    {
        return new Rsc_Menu_Item($this->menuSlug, $this->resolver);
    }

    /**
     * @param string $handle The handle of the item
     * @param Rsc_Menu_Item $submenu An instance of the submenu item class
     * @return Rsc_Menu_Page
     */
    public function addSubmenuItem($handle, Rsc_Menu_Item $submenu)
    {
        $this->submenu[$handle] = $submenu;
        return $this;
    }

    /**
     * Remove submenu
     * @param string $handle The handle of the item
     * @return bool TRUE on success, FALSE otherwise
     */
    public function deleteSubmenuItem($handle)
    {
        if (isset($this->submenu[$handle])) {
            unset ($this->submenu[$handle]);
            return true;
        }

        return false;
    }

    /**
     * Returns an instance of the submenu item
     * @param string $handle The handle of the submenu item
     * @return null|Rsc_Menu_Item
     */
    public function getSubmenuItem($handle)
    {
        if (isset($this->submenu[$handle])) {
            return $this->submenu[$handle];
        }

        return null;
    }

    /**
     * Register menu page
     */
    public function register()
    {
        add_action('admin_menu', array($this, 'addMenuPage'));
		if(is_array($this->submenu) && count($this->submenu) > 0) {
			usort($this->submenu, array($this, 'sortSubMenuItemsClb'));
            /** @var Rsc_Menu_Item $submenu */
            foreach ($this->submenu as $submenu) {
                add_action('admin_menu', array($submenu, 'register'));
            }
        }
    }
	
	public function sortSubMenuItemsClb($a, $b) {
		$sortOrderA = $a->getSortOrder();
		$sortOrderB = $b->getSortOrder();
		if($sortOrderA == $sortOrderB)
			return 0;
		if($sortOrderA > $sortOrderB)
			return 1;
		if($sortOrderA < $sortOrderB)
			return -1;
	}

    /**
     * Add menu page
     * @return mixed
     */
    public function addMenuPage()
    {
		do_action(sprintf('%s_before_menu_page_create', $this->resolver->getEnvironment()->getPluginName()), $this);

		$parameters = array(
            $this->pageTitle,
            $this->menuTitle,
            $this->getCapability(),
            $this->menuSlug,
            array($this->resolver, 'resolve'),
            $this->iconUrl,
            $this->position
        );

        return call_user_func_array('add_menu_page', $parameters);
    }
}