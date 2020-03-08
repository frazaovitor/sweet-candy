<?php

/**
 * Class SupsysticGallery
 * Grid Gallery Plugin
 */
class SupsysticGallery
{
    /**
     * @var Rsc_Environment
     */
    private $environment;

    /**
     * @var array
     */
    private $alerts;

    /**
     * Constructor
     */
    public function __construct($version)
    {
        if (!class_exists('Rsc_Autoloader', false)) {
            require dirname(dirname(__FILE__)) . '/vendor/Rsc/Autoloader.php';
            Rsc_Autoloader::register();
        }
        add_action('init', array($this, '_loadPluginsTextdomain'));
        add_action('init', array($this, 'addShortcodeButton'));

        /* Create new plugin $environment */
        $pluginPath = dirname(dirname(__FILE__));
        $environment = new Rsc_Environment('sgg', $version, $pluginPath);

        /* Configure */
        $environment->configure(
            array(
                'optimizations' => 0,
                'environment' => $this->getPluginEnvironment(),
                'default_module' => 'galleries',
                'lang_domain' => 'sgg',
                'lang_path' => plugin_basename(dirname(__FILE__)) . '/langs',
                'plugin_prefix' => 'GridGallery',
                'plugin_source' => dirname(dirname(__FILE__)) . '/src',
                'plugin_title_name' => 'Photo Gallery by Supsystic',
                'plugin_menu' => array(
                    'page_title' => __('Gallery by Supsystic', 'sgg'),
                    'menu_title' => __('Gallery by Supsystic', 'sgg'),
                    'capability' => 'manage_options',
                    'menu_slug' => 'supsystic-gallery',
                    'icon_url' => 'dashicons-format-gallery',
                    'position' => '100.3',
                ),
                'shortcode_name' => 'supsystic-gallery',
                'db_prefix' => 'sg_',
                'hooks_prefix' => 'sg_',
                'page_url' => 'http://supsystic.com/plugins/photo-gallery/',
                'ajax_url' => admin_url('admin-ajax.php'),
                'admin_url' => admin_url(),
                'uploads_rw' => true,
                'jpeg_quality' => 95,
                'plugin_db_update' => true,
                'revision' => 244,
                'welcome_page_was_showed' => get_option('sg_welcome_page_was_showed'),
                'promo_controller' => 'GridGallery_Promo_Controller',
				'plugin_folder_name' => basename(dirname(dirname(__FILE__))),
            )
        );

        if (!defined('S_YOUR_SECRET_HASH_'. $environment->getPluginName())) {
            define(
                'S_YOUR_SECRET_HASH_' . $environment->getPluginName(),
                'hn48SgUyMN53#jhg7@pomnE9W2O#2m@awmMneuGW3512F@jnkj'
            );
        }

        $this->environment = $environment;
        $this->alerts = array();

        $this->initialize();
    }

    /**
     * Run plugin
     */
    public function run()
    {
        global $grid_gallery_supsystic;

        $this->environment->run();
        $this->environment->getTwig()->addGlobal('core_alerts', $this->alerts);

        $grid_gallery_supsystic = $this->environment;
    }

    /**
     * Load plugin languages
     */
    public function _loadPluginsTextDomain()
    {
        load_plugin_textdomain(
            'sgg',
            false,
            $this->environment->getConfig()->get('lang_path')
        );
    }

    public function addShortcodeButton() {
        add_filter( "mce_external_plugins", array($this, 'addButton'));
        add_filter( 'mce_buttons', array($this, 'registerButton'));
        if(is_admin()) {
            wp_enqueue_script('sgg-bpopup-js', $this->environment->getConfig()->get('plugin_url') . '/app/assets/js/jquery.bpopup.min.js',array('sg-ajax.js'),false,true);
            wp_enqueue_style('sgg-popup-css', $this->environment->getConfig()->get('plugin_url') . '/app/assets/css/editor-dialog.css');
        }
    }

    /**
     * Add button to TinyMCE
     * @param array $plugin_array
     * @return array $plugin_array
     */
    public function addButton( $plugin_array ) {
        $plugin_array['addShortcode'] = $this->environment->getConfig()->get('plugin_url') . '/app/assets/js/buttons.js';

        return $plugin_array;
    }

    /**
     * Register button
     */
    public function registerButton( $buttons ) {
        array_push( $buttons, 'addShortcode', 'selectShortcode' );

        return $buttons;
    }

    /**
     * Initialize plugin component and subsustem
     */
    protected function initialize()
    {
        $config = $this->environment->getConfig();
        $logger = null;

        $uploads = wp_upload_dir();

        if (!is_writable($uploads['basedir'])) {
            $this->alerts[] = sprintf(
                '<div class="error">
                    <p>You need to make your "%s" directory writable.</p>
                </div>',
                $uploads['basedir']
            );

            $config->set('uploads_rw', false);
        }

        /* Create the plugin directories if they are does not exists yet. */
        $this->initFilesystem();

        /* Initialize cache null-adapter by default */
        $cacheAdapter = new Rsc_Cache_Dummy();

        /* Initialize the log system first. */
        if (null !== $logDir = $config->get('plugin_log', null)) {
            if (is_dir($logDir) && is_writable($logDir)) {
                $logger = new Rsc_Logger($logDir);
                $this->environment->setLogger($logger);
            }
        }

        /* If it's a production environment and cache directory is OK */
        if ($config->isEnvironment(Rsc_Environment::ENV_PRODUCTION)
            && null !== $cacheDir = $config->get('plugin_cache', null)
        ) {
            if (is_dir($cacheDir) && is_writable($cacheDir)) {
                $cacheAdapter = new Rsc_Cache_Filesystem($cacheDir);
            } else {
                if ($logger) {
                    $logger->error(
                        'Cache directory "{dir}" is not writable or does not exists.',
                        array(
                            'dir' => realpath($cacheDir),
                        )
                    );
                }
            }
        }

        $this->environment->setCacheAdapter($cacheAdapter);
    }

    /**
     * Creates plugin's directories.
     */
    protected function initFilesystem()
    {
        $directories = array(
            'tmp' => '/grid-gallery',
            'log' => '/grid-gallery/log',
            'cache' => '/grid-gallery/cache',
            'cache_galleries' => '/grid-gallery/cache/galleries',
            'cache_twig' => '/grid-gallery/cache/twig',
        );

        foreach ($directories as $key => $dir) {
            if (false !== $fullPath = $this->makeDirectory($dir)) {
                $this->environment->getConfig()->add('plugin_' . $key, $fullPath);
            }
        }
    }

    /**
     * Make directory in uploads directory.
     * @param string $directory Relative to the WP_UPLOADS dir
     * @return bool|string FALSE on failure, full path to the directory on success
     */
    protected function makeDirectory($directory)
    {
        $uploads = wp_upload_dir();

        $basedir = $uploads['basedir'];
        $dir = $basedir . $directory;
        if (!is_dir($dir)) {
            if (false === @mkdir($dir, 0775, true)) {
                return false;
            }
        } else {
            if (! is_writable($dir)) {
                return false;
            }
        }

        return $dir;
    }

    /**
     * Get plugin enviroment develop or production
     * @return Rsc_Environment ENV_PRODUCTION or ENV_DEVELOPMENT
     */
    protected function getPluginEnvironment()
    {
        $environment = Rsc_Environment::ENV_PRODUCTION;

        if (defined('WP_DEBUG') && WP_DEBUG) {
            if (defined('SUPSYSTIC_GRID_GALLERY_DEBUG') && SUPSYSTIC_GRID_GALLERY_DEBUG) {
                $environment = Rsc_Environment::ENV_DEVELOPMENT;
            }
        }

        return $environment;
    }

    /**
     * get gallery Environment for other supsystic plugins
     * @return Rsc_Environment
     */
    public function getEnvironment() {
        return $this->environment;
    }
}
