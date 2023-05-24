<?php

namespace NiceModules\Core\Router;


use NiceModules\Core\Router;

class FrontendRouter extends Router
{
    public function route(): ?string
    {
        $uri = parse_url($_SERVER['REQUEST_URI']);
        $path = trim($uri['path'], '/');
        if (isset($this->routes[$path])) {
            $route = $this->routes[$path];
            return call_user_func([$route->getController(), $route->getControllerMethod()]);
        }

        return null;
    }
}