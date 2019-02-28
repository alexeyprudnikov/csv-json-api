<?php
/**
 * Created by PhpStorm.
 * User: aprudnikov
 * Date: 2019-02-11
 * Time: 16:29
 */

namespace SittingPlan\Lib;

class Route
{
    /**
     * @var mixed|string
     */
    protected $path;
    /**
     * @var mixed|null
     */
    protected $controller;
    /**
     * @var mixed|null
     */
    protected $action;
    /**
     * @var mixed|string
     */
    protected $method;
    /**
     * @var array|mixed
     */
    protected $params;

    /**
     * Route constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->path = array_key_exists('path', $data) ? $data['path'] : '';
        $this->controller = $data['controller'] ?? null;
        $this->action = $data['action'] ?? null;
        $this->method = array_key_exists('method', $data) ? $data['method'] : 'GET';
        $this->params = array_key_exists('params', $data) ? $data['params'] : [];
    }

    /**
     * @return mixed|string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed|null
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed|null
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed|null
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return array|mixed
     */
    public function getParams()
    {
        return $this->params;
    }
}