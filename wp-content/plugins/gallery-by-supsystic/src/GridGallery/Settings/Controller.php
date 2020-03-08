<?php

/**
 * Class GridGallery_Settings_Controller
 * Settings Controller
 *
 * @package GridGallery\Settings
 * @author Artur Kovalevsky
 */
class GridGallery_Settings_Controller extends GridGallery_Core_BaseController
{

    /**
     * {@inheritdoc}
     */
    protected function getModelAliases()
    {
        return array(
            'settings' => 'GridGallery_Settings_Model_Settings',
        );
    }

    /**
     * Index Action
     * Shows the settings page
     *
     * @param Rsc_Http_Request $request
     * @return Rsc_Http_Response
     */
    public function indexAction(Rsc_Http_Request $request)
    {
        $module = $this->getModule('settings');
        $module->loadAssets();
        $templates = $module->getTemplatesAliases();
        $settings = get_option($this->getConfig()->get('db_prefix') . 'settings');
        try {
            return $this->response(
                $templates['settings.index'],
                array('settings' => $settings)
            );
        } catch (Exception $e) {
            return $this->response('error.twig', array('exception' => $e));
        }
    }

    public function requireNonces() {
        return array(
            'saveSettingsActionAction',
        );
    }

    public function saveSettingsAction(Rsc_Http_Request $request) {

        $optionsName = $this->getConfig()->get('db_prefix') . 'settings';
        $currentSettings = get_option($optionsName);
        $settings = $request->post->get('settings', array());

        if (!$currentSettings) {
            $currentSettings = array();
        }

        if (!current_user_can('manage_options')) {
            if (isset($currentSettings['access_roles'])) {
                $settings['access_roles'] = $currentSettings['access_roles'];
            }
        }

        if (!$this->isPro()) {
            $settings['access_roles'] = array('administrator');
        }

        $diff = @array_diff($settings, $currentSettings);
        $intersect = @array_intersect($settings, $currentSettings);
        $merge = array_merge($intersect, $diff);

        update_option($optionsName, $merge);
        return $this->redirect($this->generateUrl('settings'));
    }
}