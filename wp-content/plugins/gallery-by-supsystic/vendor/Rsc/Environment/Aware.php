<?php


class Rsc_Environment_Aware implements Rsc_Environment_AwareInterface
{

    /**
     * @var Rsc_Environment
     */
    protected $environment;

    /**
     * Sets the environment.
     *
     * @param Rsc_Environment $environment
     */
    public function setEnvironment(Rsc_Environment $environment)
    {
        $this->environment = $environment;
    }
}