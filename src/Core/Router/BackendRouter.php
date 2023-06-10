<?php

namespace NiceModules\Core\Router;

use NiceModules\Core\Request;
use NiceModules\Core\Router;

class BackendRouter extends Router
{
    public function route(): ?string
    {
        $uri = $this->request->get('page', false, Request::ROUTING);

        if (!$uri) {
            $uri = $this->request->get('action', null, Request::ROUTING);
        }
        
        if (isset($this->routes[$uri])) {
            $this->route = $this->routes[$uri];
            return call_user_func([$this->route->getController(), $this->route->getControllerMethod()]);
        }

        return null;
    }
}