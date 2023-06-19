<?php

namespace NiceModules\Core;

use NiceModules\Core\Lang\Locales;
use NiceModules\Core\I18n\InterfaceI18n;

class Context extends Singleton
{
    protected Request $request;
    protected Controller $controller;
    protected Plugin $activePlugin;
    protected InterfaceI18n $interfaceI18n;

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

    /**
     * @return InterfaceI18n
     */
    public function getInterfaceTranslator(): InterfaceI18n
    {
        if(!isset($this->interfaceI18n)){
            $locales = new Locales(); 
            $locale = get_user_locale();
            $this->interfaceI18n = new InterfaceI18n($locales->getLocaleLang($locale));
            $this->interfaceI18n->setDir($this->getActivePlugin()->getModule()->getLangDir());
        }
        
        return $this->interfaceI18n;
    }
}