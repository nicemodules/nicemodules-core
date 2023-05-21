<?php

namespace NiceModules\Core;

use ReflectionClass;

abstract class Module extends Singleton
{
    const VERSION = '';
    const CODE_NAME = '';
    const NAMESPACE = '';
    const ICON = 'dashicons-admin-tools';
    
    public function getModuleUrl(): string
    {
        $reflector = new ReflectionClass(get_called_class());
        return plugin_dir_url($reflector->getFileName()); 
    }

    public function getModuleDir(): string
    {
        $reflector = new ReflectionClass(get_called_class());
        return plugin_dir_path($reflector->getFileName());
    }

    public function getTemplatesDir(): string
    {
        $reflector = new ReflectionClass(get_called_class());
        return implode(DIRECTORY_SEPARATOR, [
            $this->getModuleDir(),
            $reflector->getConstant('NAMESPACE'), 
            'Templates'
        ]); 
    }
}