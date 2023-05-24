<?php

namespace NiceModules\Core\Router;

use NiceModules\Core\Context;
use NiceModules\Core\Controller;
use ReflectionClass;
use ReflectionException;

class Route
{
    protected string $uri;
    protected array $callback;
    protected string $controllerClass;
    protected string $controllerMethod;
    protected bool $ajax;

    /**
     * @param string $uri
     * @param string $controllerClass
     * @param string $controllerMethod
     * @param bool $ajax
     */
    public function __construct(string $uri, string $controllerClass, string $controllerMethod, $ajax = false)
    {
        $this->uri = $uri;
        $this->controllerClass = $controllerClass;
        $this->controllerMethod = $controllerMethod;
        $this->ajax = $ajax;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return Controller
     * @throws ReflectionException
     */
    public function getController(): Controller
    {
        $rfl = new  ReflectionClass($this->controllerClass);
        $controllerInstance = $rfl->newInstance();
        Context::instance()->setController($controllerInstance);

        return $controllerInstance;
    }

    /**
     * @return string
     */
    public function getControllerMethod(): string
    {
        return $this->controllerMethod;
    }

    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        return $this->ajax;
    }
}