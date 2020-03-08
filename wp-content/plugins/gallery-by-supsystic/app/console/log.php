<?php

/**
 * Usage (UNIX):
 *  - php app/console/log.php - Print full log file
 *  - php app/console/log.php | grep %level|time|word% - Print only messages with the specified level (time, word, etc)
 */

if (PHP_SAPI !== 'cli') {
    die ('Execute current script only from command-line');
}

define('LOGPATH', realpath(__DIR__ . '/../../../../uploads/grid-gallery/log'));

if (is_file($file = LOGPATH . '/' . date('Y-m-d') . '.log')) {

    echo file_get_contents($file);

}
