<?php


class Rsc_Form_Filter_Custom implements Rsc_Form_Filter_Interface
{

    public $function;

    /**
     * Constructor
     * @param callable $function
     */
    public function __construct(Callable $function)
    {
        $this->function = $function;
    }

    /**
     * Filters data
     * @param mixed $data The data that filter will be applied
     * @return mixed
     */
    public function apply($data)
    {
        return call_user_func_array($this->function, array($data));
    }
}