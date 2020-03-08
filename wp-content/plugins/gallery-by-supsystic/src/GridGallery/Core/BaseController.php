<?php

/**
 * Class GridGallery_Core_BaseController
 * This class extends the default framework controller and adds some simple features to prevent duplication of the code
 *
 * @package GridGallery\Core
 * @author Artur Kovalevsky
 */
class GridGallery_Core_BaseController extends Rsc_Mvc_Controller
{

    /**
     * Constructor
     */
    public function __construct(Rsc_Environment $environment, Rsc_Http_Request $request)
    {
        parent::__construct($environment, $request);
        if ($environment->isPluginPage() && !$environment->isModule('license')
            && !$environment->isModule('promo', 'welcome') && !$environment->getConfig()->get('welcome_page_was_showed')) {
            return $this->redirect($this->generateUrl('promo', 'welcome'));
        }
    }

	public function response($template, array $data = array())
	{
		if ($template === 'ajax') {
			//ob_clean();

			$baseModel = new GridGallery_Core_BaseModel();
			$error = $baseModel->getLastError();
			
			if ($error) {
				$data['success'] = false;
				$data['databaseError'] = $error;
			}
			if (isset($data['status'])) {
				status_header($data['status']);
			}
		}
		return parent::response($template, $data);
	}

    /**
     * Returns the simple response's data array
     *
     * @param bool $isError
     * @param string $message
     * @param array $additional
     * @return array
     */
    public function getResponseData($isError, $message = '', $additional = array())
    {
        $data = array(
            'error' => (bool)$isError,
            'message' => $message,
        );

        return array_merge($data, $additional);
    }

    /**
     * Returns the simple error response's data array
     *
     * @param string $message
     * @param array $additional
     * @return array
     */
    public function getErrorResponseData($message = '', $additional = array())
    {
        return $this->getResponseData(true, $message, $additional);
    }

    /**
     * Returns the simple success response's data array
     *
     * @param string $message
     * @param array $additional
     * @return array
     */
    public function getSuccessResponseData($message = '', $additional = array())
    {
        return $this->getResponseData(false, $message, $additional);
    }

    /**
     * Checks whether the current environment is production
     *
     * @return bool
     */
    public function isProduction()
    {
        return $this->getEnvironment()->getConfig()->isEnvironment(Rsc_Environment::ENV_PRODUCTION);
    }

    /**
     * Returns the instance of the selected module
     * You can specify an instance of the controller as $module the method will return an
     * instance if module of the specified controller.
     *
     * @param string|object $module The name of the module or an instance of the controller
     * @return Rsc_Mvc_Module|null
     */
    public function getModule($module)
    {
        if (is_object($module)) {
            preg_match('/GridGallery_(.*)_(.*)/', get_class($module), $matches);

            $module = strtolower(isset($matches[1]) ? $matches[1] : null);
        }

        return $this->getEnvironment()->getModule($module);
    }

    /**
     * Creates the new instance of the model and returns it
     *
     * @param string $modelName
     * @return Rsc_Mvc_Model|GridGallery_Core_BaseModel
     * @throws RuntimeException
     */
    public function getModel($modelName)
    {
        $aliases = $this->getModelAliases();

        if (!isset($aliases[$modelName])) {
            throw new RuntimeException(
                sprintf(
                    $this->getEnvironment()->getLang()->translate(
                        'The model %s is does not registered with method GridGallery_Core_BaseController::getModelAliases()'
                    ),
                    $modelName
                )
            );
        }

        $model = new $aliases[$modelName];
		if($model) {
			if(method_exists($model, 'setEnvironment')) {
				$model->setEnvironment($this->getEnvironment());
			}
			if(method_exists($model, 'onInit')) {
				$model->onInit();
			}
		}

        if (!$this->isProduction()) {

            if (method_exists($model, 'setDebugEnabled')) {
                $model->setDebugEnabled(true);
            }

            if ($model instanceof Rsc_Logger_AwareInterface) {
                if ($logger = $this->getEnvironment()->getLogger()) {
                    $model->setLogger($logger);
                }
            }
        }

        return $model;
    }

    /**
     * Returns the array of the models aliases
     *
     * @return array
     */
    protected function getModelAliases()
    {
        return array();
    }

    /**
     * Saves the statistics event.
     * @param string $event Event name.
     */
    protected function saveEvent($event)
    {
        $stats = $this->getModule('stats');

        if (!is_object($stats)) {
            return;
        }

        $stats->save($event);
    }

    public function translate($text)
    {
        /*return $this->getEnvironment()
            ->getLang()
            ->translate($text);*/
        return __($text, 'sgg');
    }

    public function escape($text)
    {
        if (is_array($text)) {
            return array_map(array($this, 'escape'), $text);
        }

        return htmlspecialchars($text, ENT_QUOTES, get_bloginfo('charset'));
    }
}
