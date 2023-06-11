<?php

namespace NiceModules\Core;

use NiceModules\Core\Router\Route;

abstract class Router
{
    /**
     * @var Route[]
     */
    protected array $routes;
    protected Request $request;
    protected Route $route;
    protected array $uris;
    
    public function __construct()
    {
        $this->request = Context::instance()->getRequest();
    }

    abstract public function route(): ?string;

    /**
     * @param Route $route
     * @return $this
     */
    public function addRoute(Route $route): Router
    {
        $this->routes[$route->getUri()] = $route;
        $this->uris[$route->getControllerClass()][$route->getControllerMethod()] = $route->getUri();
        return $this;
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    /**
     * @param $controller
     * @param $method
     * @return mixed|null
     */
    public function getUri($controller, $method): ?string
    {
        if(isset($this->uris[$controller][$method])){
            return $this->uris[$controller][$method];
        }
        
        return null;
    }

    /**
     * @return array
     */
    public function getUris(): array
    {
        return $this->uris;
    }

}