<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-04
 * Time: 17:16
 */

if (!is_file('src/Controllers/Core.php')) {
    die('Cannot find src/Controllers/Core.php. Possibly your CWD is wrong' . PHP_EOL);
}
if (!is_file('src/includes/config.php')) {
    die('Cannot find src/includes/config.php. Possibly your CWD is wrong' . PHP_EOL);
}

require_once 'src/includes/config.php';
include 'Autoloader.php';

use SittingPlan\Controllers\Core;
use SittingPlan\Lib\Routing;
use SittingPlan\Lib\SystemException;

class CoreMock extends Core
{
    public function __construct()
    {
        try {
            $Routing = new Routing();
        } catch (SystemException $Exception) {
            $Exception->outputErrorAsJson();
            exit();
        }
        parent::__construct($Routing);
    }

    public function start(): void
    {
    }

    public function getRouting(): Routing
    {
        return $this->Routing;
    }
}