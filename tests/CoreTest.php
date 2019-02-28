<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-07
 * Time: 15:55
 */
require_once 'tests/CoreMock.php';
require_once 'tests/TestBaseTrait.php';

use PHPUnit\Framework\TestCase;
use SittingPlan\Lib\SystemException;
use SittingPlan\Controllers\Output;

class CoreTest extends TestCase
{
    use TestBaseTrait;
    /**
     * config constants
     */
    public function testConfig(): void
    {
        $this->assertTrue(defined('DATAFILE'));
        $this->assertTrue(defined('ROUTES_PATH'));
    }

    /**
     * db and route files
     */
    public function testRoutePath(): void
    {
        $this->assertFileExists(ROUTES_PATH);
        $this->assertFileIsReadable(ROUTES_PATH);
    }

    /**
     * controllers loaded
     */
    public function testControllerLoader(): void
    {
        try {
            $CoreMock = new CoreMock();
            $controller = $this->invokeMethod($CoreMock,'initController', ['Output']);
            $this->assertNotNull($controller);
            $controller = $this->invokeMethod($CoreMock,'initController', ['Import']);
            $this->assertNotNull($controller);
        } catch (SystemException $e) {
            $this->fail($e->getMessage());
        } catch (ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * call controller method Output_showData
     */
    public function testCall_Output_showData(): void
    {
        $routeData = json_decode('{
            "/api/room/": {
            "controller": "Output",
            "action": "showData",
            "method": "GET"
          }
        }', 1);

        try {
            $CoreMock = new CoreMock();
            $Routing = $CoreMock->getRouting();
            $Routing->setRoutesData($routeData);
            $route = $Routing->getRoute('/api/room/', 'GET');

            $controller = $this->invokeMethod($CoreMock,'initController', ['Output']);
            $action = $this->invokeMethod($CoreMock,'initAction', [$controller, $route->getAction()]);
            $this->assertEquals('showData', $action);

        } catch (SystemException $e) {
            $this->fail($e->getMessage());
        } catch (ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * call controller method Import_importData
     */
    public function testCall_Import_importData(): void
    {
        $routeData = json_decode('{
            "/api/import/": {
            "controller": "Import",
            "action": "importData",
            "method": "POST"
          }
        }', 1);

        try {
            $CoreMock = new CoreMock();
            $Routing = $CoreMock->getRouting();
            $Routing->setRoutesData($routeData);
            $route = $Routing->getRoute('/api/import/', 'POST');

            $controller = $this->invokeMethod($CoreMock, 'initController', ['Import']);
            $action = $this->invokeMethod($CoreMock,'initAction', [$controller, $route->getAction()]);
            $this->assertEquals('importData', $action);
        } catch (SystemException $e) {
            $this->fail($e->getMessage());
        } catch (ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testExceptionInitController(): void
    {
        $this->expectException(SystemException::class);
        $CoreMock = new CoreMock();
        $controller = $this->invokeMethod($CoreMock,'initController', ['FalseController']);
    }

    public function testExceptionInitAction(): void
    {
        $this->expectException(SystemException::class);
        $CoreMock = new CoreMock();
        $action = $this->invokeMethod($CoreMock,'initAction', [new Output(), 'falseAction']);
    }

    public function testSystemException(): void
    {
        $SystemException = new SystemException();
        $SystemException->setHttpCode(404);
        $this->assertEquals(404, $SystemException->getHttpCode());

        $this->assertNotFalse($SystemException->outputErrorAsJson(true));
    }
}