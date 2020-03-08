<?php


interface Rsc_Config_ListenerInterface
{

    public function onAdd($key, $value);
    public function onUpdate($key, $value);
    public function onDelete($key);
    public function onGet($key);

} 