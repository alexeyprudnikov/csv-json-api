<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-04
 * Time: 17:13
 */

require_once 'tests/CoreMock.php';

use PHPUnit\Framework\TestCase;
use SittingPlan\Lib\SystemException;
use SittingPlan\Lib\Routing;
use SittingPlan\Lib\Route;


class RoutingTest extends TestCase
{
    /**
     * @var Routing
     */
    protected static $Routing;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        try {
            self::$Routing = new Routing(ROUTES_PATH);
        } catch (SystemException $e) {
            self::fail($e->getMessage());
        }
    }

    /**
     * load
     */
    public function testLoading(): void
    {
        try {
            $this->assertTrue((new Routing())->load(ROUTES_PATH));
            $this->assertFalse((new Routing())->load('ewrwerewrwer'));
        } catch (SystemException $e) {
            self::fail($e->getMessage());
        }
    }

    public function testExceptionConstruct(): void
    {
        $this->expectException(SystemException::class);
        $Routing = new Routing('fsfsfsdfsd');
    }

    /**
     * json routes loaded
     */
    public function testLoader(): void
    {
        $this->assertNotCount(0, self::$Routing->getRoutesData());
    }

    /**
     * route object set
     */
    public function testSetter(): void
    {

        $routeData = json_decode('{
            "path": "/some/path/toRoute/",
            "controller": "someController",
            "action": "someAction",
            "method": "GET",
            "params": [
              "number"
            ]
        }', 1);

        $route = new Route($routeData);

        $this->assertEquals($routeData['path'], $route->getPath());
        $this->assertEquals($routeData['controller'], $route->getController());
        $this->assertEquals($routeData['action'], $route->getAction());
        $this->assertEquals($routeData['method'], $route->getMethod());
        $this->assertEquals($routeData['params'], $route->getParams());
    }

    /**
     * not allowed route
     */
    public function testMatchNotAllowed(): void
    {
        $routeData = json_decode('{
            "path": "/some/path/toAllowedRoute/",
            "controller": "someController",
            "action": "someAction"
        }', 1);

        $route = new Route($routeData);

        $this->assertNotCount(0, self::$Routing->match('/some/path/toAllowedRoute/', $route->getPath()));
        $this->assertCount(0, self::$Routing->match('/some/path/toNotAllowedRoute/', $route->getPath()));
    }

    /**
     * allowed route w/o dynamic parameter
     */
    public function testMatch(): void
    {
        $routeData = json_decode('{
            "path": "/some/path/toRoute/",
            "controller": "someController",
            "action": "someAction"
        }', 1);

        $route = new Route($routeData);

        $this->assertNotCount(0, self::$Routing->match('/some/path/toRoute/', $route->getPath()));
        $this->assertCount(0, self::$Routing->match('/some/path/toRoute/1234', $route->getPath()));
    }

    /**
     * allowed route with dynamic parameter
     */
    public function testMatch_DynamicTail(): void
    {
        $routeData = json_decode('{
            "path": "/some/path/toRoute/?",
            "controller": "someController",
            "action": "someAction",
            "params": [
              "number"
            ]
        }', 1);

        $route = new Route($routeData);

        $this->assertNotCount(0, self::$Routing->match('/some/path/toRoute/', $route->getPath()));
        $this->assertNotCount(0, self::$Routing->match('/some/path/toRoute/1234', $route->getPath()));
        $this->assertNotCount(0, self::$Routing->match('/some/path/toRoute/xxxx', $route->getPath()));
    }

    /**
     * global routing with get route instance
     */
    public function testGetRoute(): void
    {
        $routeData = json_decode('{
            "/some/path/toRoute/": {
            "controller": "someController",
            "action": "someAction",
            "method": "GET"
          }
        }', 1);

        self::$Routing->setRoutesData($routeData);
        try {
            $route = self::$Routing->getRoute('/some/path/toRoute/', 'GET');
            $this->assertNotNull($route);
        } catch (SystemException $e) {
            $this->fail($e->getMessage());
        }
    }

}