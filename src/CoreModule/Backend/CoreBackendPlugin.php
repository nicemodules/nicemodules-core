<?php

namespace NiceModules\CoreModule\Backend;

use NiceModules\Core\Plugin\BackendPlugin;

class CoreBackendPlugin extends BackendPlugin
{
    protected function initializePlugin(){
        $this->module = CoreModule::instance();
    }
}