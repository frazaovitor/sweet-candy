<?php

/**
 * Class GridGallery_Developer_Controller
 * The controller of the Developer module
 *
 * @package GridGallery\Developer
 * @author Artur Kovalevsky
 */
class GridGallery_Developer_Controller extends Rsc_Mvc_Controller
{
    public function requireNonces() {
        return array(
            'logAction',
        );
    }

    /**
     * Index Action
     * @return Rsc_Http_Response
     */
    public function indexAction()
    {
        $model = new GridGallery_Developer_Model();

        return $this->response('@developer/index.twig', array(
            'php' => $model->getPhpData(),
            'wordpress' => $model->getWordpressData(),
            'plugin' => $this->getEnvironment()->getConfig()->all(),
        ));
    }

    /**
     * Log Action
     */
    public function logAction(Rsc_Http_Request $request)
    {
        if (!$date = $request->query->get('date')) {
            $date = date('Y-m-d');
        }

        if (is_file($filename = $this->getEnvironment()->getConfig()->get('plugin_log') . '/' . $date . '.log')) {
            $data = file_get_contents($filename);
        } else {
            $data = null;
        }

        return $this->response('@developer/log.twig', array(
            'log' => $data,
        ));
    }
} 