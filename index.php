<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-04
 * Time: 15:38
 */

require_once 'src/includes/config.php';
include 'Autoloader.php';

use SittingPlan\Controllers\Core;
use SittingPlan\Lib\Routing;
use SittingPlan\Lib\SystemException;

// load routing
try {
    $Routing = new Routing(ROUTES_PATH);
} catch (SystemException $Exception) {
    $Exception->outputErrorAsJson();
    exit();
}

$Core = new Core($Routing);

$Core->start();