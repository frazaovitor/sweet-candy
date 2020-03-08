<?php

/**
 * Describes a logger-aware instance
 */
interface Rsc_Logger_AwareInterface
{
    /**
     * Sets a logger instance on the object
     *
     * @param Rsc_Logger_Interface $logger
     * @return null
     */
    public function setLogger(Rsc_Logger_Interface $logger);
}