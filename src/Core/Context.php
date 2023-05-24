<?php

namespace NiceModules\Core;

class Context extends Singleton
{
    protected Request $request;
    protected Controller $controller;
    protected Plugin $activePlugin;

    protected function __construct()
    {
        $this->request = new Request();
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     * @return Context
     */
    public function setController(Controller $controller): Context
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return Plugin
     */
    public function getActivePlugin(): Plugin
    {
        return $this->activePlugin;
    }

    /**
     * @param Plugin $activePlugin
     */
    public function setActivePlugin(Plugin $activePlugin): void
    {
        $this->activePlugin = $activePlugin;
    }
}