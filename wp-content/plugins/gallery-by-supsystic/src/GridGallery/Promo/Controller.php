<?php 
/**
* 
*/
class GridGallery_Promo_Controller extends GridGallery_Core_BaseController
{
    public function welcomeAction(Rsc_Http_Request $request)
    {
		$model = $this->getModel('promo');
		$model->bigStatAdd('Welcome Show');
		update_option('sgg_plug_welcome_show', time());	// Remember this
        return $this->response(
            '@promo/promo.twig',
            array(
                'plugin_name' => $this->getConfig()->get('plugin_title_name'),
                'plugin_version' => $this->getConfig()->get('plugin_version'),
                'start_url' => '?page=supsystic-gallery&module=overview'
            )
        );
    }

    public function showTutorialAction()
    {
        update_user_meta(get_current_user_id(), 'sgg-tutorial_was_showed', false);
        return $this->redirect($this->generateUrl('overview'));
    }
	public function saveDeactivateDataAction(Rsc_Http_Request $request) {
		$lang = $this->getEnvironment()->getLang();
		$model = $this->getModel('promo');
		$model->saveDeactivateData($request->post);
		return $this->response(
            Rsc_Http_Response::AJAX,
            $this->getSuccessResponseData(
                $lang->translate('Hope you will come back!')
            )
        );
	}
	/**
     * {@inheritdoc}
     */
    protected function getModelAliases() {
        return array(
            'promo' => 'GridGallery_Promo_Model_Promo',
        );
    }
}