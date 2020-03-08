<?php


class Rsc_Installer_PhpParser extends Rsc_Installer_Parser
{
    /**
     * Checks whether the required resource is supported by selected parser
     *
     * @param string $resource Full path to the resource
     * @return bool
     */
    public function isSupported($resource)
    {
        return ('php' === strtolower(pathinfo($resource, PATHINFO_EXTENSION)));
    }

    /**
     * Loads the resource
     *
     * @param string $resource
     * @return mixed|false
     */
    public function loadResource($resource)
    {
        return include $resource;
    }

    /**
     * Returns the array of the queries
     *
     * @param mixed $data Resource data
     * @return array An PHP array of the queries
     */
    public function parse($data)
    {
        return $data;
    }
}