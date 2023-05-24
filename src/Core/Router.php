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

    public function __construct()
    {
        $this->request = Context::instance()->getRequest();
    }

    public function addRoute(Route $route): Router
    {
        $this->routes[$route->getUri()] = $route;
        return $this;
    }

    public function getRoute(): Route
    {
        return $this->route;
    }


    abstract public function route(): ?string;

}