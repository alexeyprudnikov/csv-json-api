<?php

/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-04
 * Time: 17:04
 */

namespace SittingPlan\Lib;

class Routing
{

    /**
     * @var array
     */
    protected $routesData = [];

    /**
     * Routing constructor.
     * @param string $path
     * @throws SystemException
     */
    public function __construct(string $path = '')
    {
        if (!empty($path) && !$this->load($path)) {
            throw new SystemException('Routing not loaded from ' . $path);
        }
    }

    /**
     * @param string $filename
     * @return bool
     */
    public function load(string $filename): bool
    {
        if (false === ($content = @file_get_contents($filename))) {
            return false;
        }
        $this->setRoutesData(json_decode($content, 1));
        return true;
    }

    /**
     * @return array
     */
    public function getRoutesData(): array
    {
        return $this->routesData;
    }

    /**
     * @param $value
     */
    public function setRoutesData($value): void
    {
        $this->routesData = $value;
    }

    /**
     * @param string $requestUri
     * @param string $requestMethod
     * @return Route
     * @throws SystemException
     */
    public function getRoute(string $requestUri = '', string $requestMethod = ''): Route
    {
        if ($requestUri === '') {
            $requestUri = array_key_exists('REQUEST_URI', $_SERVER) ? (string)$_SERVER['REQUEST_URI'] : '';
        }
        if($requestUri === '/') {
            echo 'DocumentRoot';
            exit();
        }
        if ($requestMethod === '') {
            $requestMethod = array_key_exists('REQUEST_METHOD', $_SERVER) ? (string)$_SERVER['REQUEST_METHOD'] : 'GET';
        }
        // split query parts
        $pathArray = explode('?', $requestUri);
        $data = $params = [];
        foreach ($this->routesData as $rp => $rd) {
            $matches = $this->match($pathArray[0], $rp);
            if (!empty($matches[0])) {
                // check request method
                if (array_key_exists('method', $rd) && strtoupper($rd['method']) !== $requestMethod) {
                    throw (new SystemException('Method not allowed, should be ' . strtoupper($rd['method']) . ', ' . $requestMethod . ' given'))->setHttpCode(405);
                }
                $data = $rd;
                $data['path'] = $matches[0];
                // set params from url to array
                if (array_key_exists('params', $data) && !empty($matches[1])) {
                    $pArr = explode('/', rtrim($matches[1], '/'));
                    $params = $data['params'];
                    unset($data['params']);
                    foreach ($params as $index => $param) {
                        if (array_key_exists($index, $pArr) && !empty($pArr[$index])) {
                            $data['params'][$param] = $pArr[$index];
                        }
                    }
                }
                // check $_FILES data
                if(isset($_FILES) && array_key_exists('file', $_FILES)) {
                    $data['params']['file'] = $_FILES['file']['tmp_name'];
                }
                break;
            }
        }
        if (empty($data)) {
            throw (new SystemException('Route not allowed'))->setHttpCode(400);
        }
        return new Route($data);
    }

    /**
     * @param string $requestPath
     * @param string $routePath
     * @return array
     */
    public function match(string $requestPath, string $routePath): array
    {
        // check matched url with dynamic part
        $pattern = '/' . str_replace('\?', '(.*)', preg_quote($routePath, '/')) . '$/';
        preg_match($pattern, rtrim($requestPath, '/') . '/', $matches);
        return $matches;
    }
}