<?php

/**
 * Class GridGallery_Ui_Module
 * User Interface Module
 *
 * @package GridGallery\Ui
 * @author Artur Kovalevsky
 */
class GridGallery_Ui_Module extends Rsc_Mvc_Module
{
    /**
     * @var array
     */
    protected $javascripts;

    /**
     * @var array
     */
    protected $stylesheets;

    /**
     * @var GridGallery_Ui_AssetsCollection
     */
    protected $assets;

    /**
     * {@inheritdoc}
     */
    public function onInit()
    {
        parent::onInit();
        $this->asset = new GridGallery_Ui_Assets($this);
        add_action('init', array($this, 'registerJSData'));
        $this->preload();
    }

    /**
     * Preloads the assets
     */
    public function preload()
    {
        $this->asset->enqueue('styles', $this->getBackendCSS());
        // Global
        $this->asset->enqueue(
            'styles',
            array(
                $this->getConfig()->get('plugin_url') . '/app/assets/css/supsystic-for-all-admin.css'
            ),
            'backend',
            true
        );
        $this->asset->enqueue('scripts', $this->getBackendJS());
    }

    public function getBackendCSS() {
        $url = $this->getEnvironment()->getConfig()->get('plugin_url');
        return array(
            array(
                'source' => $url . '/app/assets/css/supsystic-ui.css',
                'dependencies' => array('wp-color-picker'),
            ),
            $url . '/app/assets/css/supsystic-jgrowl.css',
            $url . '/app/assets/css/animate.css',
            $url . '/app/assets/css/minimal/minimal.css',
            $url . '/app/assets/css/libraries/fontawesome/font-awesome.min.css',
            $this->getLocationUrl() . '/css/tooltipster.css',
            '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css',
            // '//cdn.jsdelivr.net/jquery.tooltipster/2.1.4/css/tooltipster.css',
            //'//fonts.googleapis.com/css?family=Montserrat',
        );
    }

    public function registerJSData() {
        wp_register_script('sg-ajax.js', $this->getLocationUrl() . '/js/ajax.js');
        wp_localize_script('sg-ajax.js', 'SupsysticGallery', array('nonce' => wp_create_nonce('supsystic-gallery')));
		// really assigned to /app/assets/js/grid-gallery.js Handle
		wp_localize_script('sg-ajax.js', 'sggParams', array('isRtl' => (int) is_rtl()));
        wp_localize_script('sg-ajax.js', 'sggStandartFontsList', $this->getStandardFontsList());
        if($this->getEnvironment()->isPro()) {
            if(version_compare($this->getEnvironment()->getConfig()->get('pro_plugin_version'), '2.7.6', '<')) {
                wp_enqueue_script('webfont-js', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js');
            }
        }
    }

    public function getBackendJS() {
        $url = $this->getEnvironment()->getConfig()->get('plugin_url');


        return array(
            array(
                'source' => $this->getLocationUrl() . '/js/ajax.js',
                'handle' => 'sg-ajax.js'
            ),
            array(
                'source' => $url . '/app/assets/js/grid-gallery.js',
                'dependencies' => array('jquery', 'jquery-ui-dialog'),
            ),
            $url . '/app/assets/js/icheck.min.js',
            $url . '/app/assets/js/jquery.lazyload.min.js',
            $url . '/app/assets/js/jquery.jgrowl.min.js',
            //$url . '/app/assets/js/webfont.js',
            array(
                'source' => $this->getLocationUrl() . '/js/colorpicker.js',
                'dependencies' =>  array('grid-gallery.js', 'wp-color-picker'),
            ),
            $this->getLocationUrl() . '/js/common.js',
            $this->getLocationUrl() . '/js/types.js',
            $this->getLocationUrl() . '/plugins/grid-gallery.ui.formSerialize.js',
            $this->getLocationUrl() . '/js/jquery.tooltipster.min.js' ,
            $this->getLocationUrl() . '/js/slimscroll.min.js',
            $this->getLocationUrl() . '/plugins/grid-gallery.ui.toolbar.js',
            $this->getLocationUrl() . '/js/checkbox-observer.js',
            $this->getLocationUrl() . '/js/toolbar.js',
            $this->getLocationUrl() . '/js/ajaxQueue.js',
        );
        
    }
    public function getStandardFontsList() {
        return array("Georgia","Palatino Linotype","Times New Roman","Arial","Helvetica","Arial Black","Gadget","Comic Sans MS","Impact","Charcoal","Lucida Sans Unicode","Lucida Grande","Tahoma","Geneva","Trebuchet MS","Verdana","Geneva","Courier New","Courier","Lucida Console","Monaco");
    }
}
