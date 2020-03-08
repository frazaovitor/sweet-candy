<?php

class GridGallery_Developer_Console
{
    const LEVEL = 4;

    public static function log($msg)
    {
        error_log($msg, self::LEVEL);
    }
}
