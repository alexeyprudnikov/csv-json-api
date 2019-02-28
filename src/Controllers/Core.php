<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-04
 * Time: 15:41
 */

namespace SittingPlan\Controllers;

use SittingPlan\Lib\Routing;
use SittingPlan\Lib\SystemException;

class Core
{
    /**
     * @var Routing
     */
    protected $Routing;

    /**
     * Core constructor.
     * @param Routing $Routing
     */
    public function __construct(Routing $Routing)
    {
        $this->Routing = $Routing;
    }

    /**
     * main call
     */
    public function start(): void
    {
        // check and init route
        try {
            $Route = $this->Routing->getRoute();
        } catch (SystemException $Exception) {
            $Exception->outputErrorAsJson();
            exit();
        }
        // load controller
        try {
            $controller = $this->initController($Route->getController());
        } catch (SystemException $Exception) {
            $Exception->outputErrorAsJson();
            exit();
        }
        // launch action
        try {
            $action = $this->initAction($controller, $Route->getAction());
        } catch (SystemException $Exception) {
            $Exception->outputErrorAsJson();
            exit();
        }
        $params = $Route->getParams();
        $controller->{$action}($params);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws SystemException
     */
    protected function initController(string $name)
    {
        $namespace = 'SittingPlan\\Controllers\\';
        $ControllerClass = $namespace . $name;
        if (!class_exists($ControllerClass)) {
            throw new SystemException('Controller: ' . $ControllerClass . ' not loaded');
        }
        return new $ControllerClass();
    }

    /**
     * @param $controller
     * @param string $name
     * @return string
     * @throws SystemException
     */
    protected function initAction($controller, string $name): string
    {
        if (!method_exists($controller, $name)) {
            throw new SystemException('Method ' . $name . ' not exists');
        }
        return $name;
    }
}