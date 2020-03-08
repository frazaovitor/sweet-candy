<?php

/**
 * Class GridGallery_Ajax_Module
 * GridGallery AJAX processor
 *
 * @package GridGallery\Ajax
 * @author Artur Kovalevsky
 */
class GridGallery_Ajax_Module extends Rsc_Mvc_Module
{

    /**
     * {@inheritdoc}
     */
    public function onInit()
    {
        parent::onInit();

        add_action('wp_ajax_grid-gallery', array($this, 'handle'));
    }

    /**
     * Handles the AJAX requests
     * @return void
     */
    public function handle()
    {
        $handler = new GridGallery_Ajax_Handler($this->getEnvironment());
        $handler->handle();
    }

    /**
     * Returns the AJAX url
     *
     * @return string
     */
    public function getAjaxUrl()
    {
        return admin_url('admin-ajax.php');
    }
} 