<?php


interface Rsc_Form_Filter_Interface
{
    /**
     * Filters data
     * @param mixed $data The data that filter will be applied
     */
    public function apply($data);
} 