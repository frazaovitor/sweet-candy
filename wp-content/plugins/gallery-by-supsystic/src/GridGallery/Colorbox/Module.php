<?php

/**
 * Class GridGallery_Colorbox_Module.
 * Registers the Colorbox in the system.
 * @package GridGallery\Colorbox
 */
class GridGallery_Colorbox_Module extends GridGallery_Core_Module
{

    /**
     * {@inheritdoc}
     */
    public function onInit()
    {
        parent::onInit();
        add_action('sg_after_ui_loaded', array($this, 'load'));
    }

    /**
     * Loads the Colorbox's plugin, locale and theme after the UI module loaded.
     * @param GridGallery_Ui_Module $ui The UI Module.
     */
    public function load(GridGallery_Ui_Module $ui)
    {
        $this->loadPlugin($ui);
        $this->loadLocale($ui);
        $this->loadTheme($ui);
    }

    /**
     * Reloads the Colorbox module.
     * @return bool
     */
    public function reload()
    {
        $ui = $this->getEnvironment()->getModule('ui');

        if (is_object($ui) && $ui instanceof GridGallery_Ui_Module) {
            $this->load($ui);

            return true;
        }

        return false;
    }

    /**
     * Returns the url to the jQuery plugin.
     * If is production environment, then will be returned the compressed
     * version of the plugin.
     *
     * @return string
     */
    protected function getPluginUrl()
    {
        $filename = 'jquery.colorbox.js';

        //disable minified js , coz of  custom functions and minor bug fixes in plugin
        if (false && $this->isProduction()) {
            $filename = 'jquery.colorbox-min.js';
        }

        return $this->getLocationUrl() . '/jquery-colorbox/' . $filename;
    }

    /**
     * Checks whether the current environment is "production".
     * @return bool
     */
    protected function isProduction()
    {
        return $this->getEnvironment()->isProd();
    }

    /**
     * Loads the jQuery plugin to the Wordpress backend and frontend.
     * @param GridGallery_Ui_Module $ui The UI Module.
     */
    protected function loadPlugin(GridGallery_Ui_Module $ui)
    {
        $colorbox = array(
            array(
                'handle' => 'jquery.colorbox.js',
                'source' => $this->getPluginUrl(),
                'dependencies' => array('jquery'), 
                'version' => $this->getConfig()->get('plugin_version'),
            )
        );
        // Frontend
        $ui->asset->register('scripts', $colorbox);
        // Backend
        $ui->asset->enqueue('scripts', $colorbox);
    }

    /**
     * Loads the translation for the colorbox.
     * @param GridGallery_Ui_Module $ui The UI Module.
     */
    protected function loadLocale(GridGallery_Ui_Module $ui)
    {
        $locale = get_locale();
        $locale = strtolower($locale);

        if (in_array($locale, array('en_us', 'en_gb'))) {
            return;
        }

        $config = $this->getEnvironment()->getConfig();
        $config->load('@colorbox/parameters.php');

        $colorbox = $config->get('colorbox');

        if (!isset($colorbox['languages'][$locale])) {
            return;
        }

        $filename = '/jquery-colorbox/i18n/' . $colorbox['languages'][$locale];

        $asset = array(
            array(
                'source' => $this->getLocationUrl() . $filename,
                'dependencies' => array('jquery.colorbox.js')
            )
        );
        $ui->asset->enqueue('scripts', $asset, 'frontend');
    }

    /**
     * Loads the colorbox theme, specified in the configuration file to the
     * plugin backend.
     * @param GridGallery_Ui_Module $ui The UI Module.
     */
    protected function loadTheme(GridGallery_Ui_Module $ui)
    {
        $config = $this->getEnvironment()->getConfig();

        if (!$config->has('colorbox')) {
            $config->load('@colorbox/parameters.php');
        }

        $colorbox = $config->get('colorbox');

        $theme = (isset($colorbox['theme']) ? $colorbox['theme'] : 'theme_1');

        //$filename = sprintf('/jquery-colorbox/themes/%s/colorbox.css', $theme);

        $themes = array(
            array(
                'handle' => 'colorbox-theme1.css',
                'source' => $this->getLocationUrl() .'/jquery-colorbox/themes/theme_1/colorbox.css',
            ),
            array(
                'handle' => 'colorbox-theme2.css',
                'source' => $this->getLocationUrl() .'/jquery-colorbox/themes/theme_2/colorbox.css',
            ),
            array(
                'handle' => 'colorbox-theme3.css',
                'source' => $this->getLocationUrl() .'/jquery-colorbox/themes/theme_3/colorbox.css',
            ),
            array(
                'handle' => 'colorbox-theme4.css',
                'source' => $this->getLocationUrl() .'/jquery-colorbox/themes/theme_4/colorbox.css',
            ),
            array(
                'handle' => 'colorbox-theme5.css',
                'source' => $this->getLocationUrl() .'/jquery-colorbox/themes/theme_5/colorbox.css',
            ),
            array(
                'handle' => 'colorbox-theme7.css',
                'source' => $this->getLocationUrl() .'/jquery-colorbox/themes/theme_7/colorbox.css',
            )
        );

        $ui->asset->register('styles', $themes);
        // $ui->asset->enqueue('styles', $themes, 'frontend');
        $ui->asset->enqueue('styles', $themes, 'backend');

        /*
            $ui->asset->enqueue('styles', array(
                    array(
                        'handle' => 'colorbox.css',
                        'source' => $this->getLocationUrl() . $filename,
                    )
                )
            );
        */
    }

    public function loadColoboxStyles() {
        $style = array('colorbox-theme1.css', 'colorbox-theme2.css', 'colorbox-theme3.css', 'colorbox-theme4.css', 'colorbox-theme5.css', 'colorbox-theme7.css');

        foreach ($style as $style) {
           wp_enqueue_style($style);
        }
    }

    public function loadUserTheme($theme)
    {
        $filename = sprintf('/jquery-colorbox/themes/%s/colorbox.css', $theme);

        $ui = $this->getEnvironment()->getModule('ui');
        
        $ui->asset->enqueue('styles', array(
            array(
                'source' => $this->getLocationUrl() . $filename,
            )
        ), 'frontend');
    }

    /**
     * Returns the full URL to the theme screenshot.
     * @param  string $themeName Theme name (theme_1, theme_2, etc).
     * @return string
     */
    public function getThemeScreenshotUrl($themeName)
    {
        $default = 'http://placehold.it/262x213&text=No+image';
        $filename = $themeName . '.jpg';
        $url = $this->getLocationUrl() . '/images/';

        if (!is_file(dirname(__FILE__) . '/images/' . $filename)) {
            return $default;
        }

        return $url . $filename;
    }
}
