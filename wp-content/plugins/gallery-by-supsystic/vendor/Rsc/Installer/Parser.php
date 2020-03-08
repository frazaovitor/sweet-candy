<?php

/**
 * Class Rsc_Installer_Parser
 * Abstract parser
 */
abstract class Rsc_Installer_Parser
{
    /**
     * @var string
     */
    private $resource;

    /**
     * Constructor
     *
     * @param string $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Returns an array of the queries
     *
     * @throws LogicException
     * @throws RuntimeException
     * @throws UnexpectedValueException
     * @return array
     */
    public function getQueries()
    {
        if (!$this->isSupported($this->resource)) {
            throw new LogicException(__('The parser is does not supports specified resource', 'rsc-framework'));
        }

        if (!is_file($this->resource)) {
            throw new UnexpectedValueException(__('The resource must be a file', 'rsc-framework'));
        }

        if (false === $data = $this->loadResource($this->resource)) {
            throw new RuntimeException(__('Failed to load the resource', 'rsc-framework'));
        }

        return $this->parse($data);
    }

    /**
     * Returns the array of the queries
     *
     * @param mixed $data Resource data
     * @return array An PHP array of the queries
     */
    abstract public function parse($data);

    /**
     * Loads the resource
     *
     * @param string $resource
     * @return mixed|false
     */
    abstract public function loadResource($resource);

    /**
     * Checks whether the required resource is supported by selected parser
     *
     * @param string $resource Full path to the resource
     * @return bool
     */
    abstract public function isSupported($resource);
} 