<?php

namespace NiceModules\Core;

use ReflectionClass;

abstract class Module extends Singleton
{
    // Define this constance for every child module 
    const VERSION = ''; // Release version
    const CODE_NAME = ''; // Name of the main folder of WordPress plugin
    const NAMESPACE = ''; // Child module class namespace and folder name
    const ICON = 'dashicons-admin-tools';

    protected ReflectionClass $reflector;

    public function __construct()
    {
        $this->reflector = new ReflectionClass(get_called_class());
    }

    public function getPluginDir()
    {
        return ABSPATH . implode(DIRECTORY_SEPARATOR, [
                'wp-content',
                'plugins',
                $this->reflector->getConstant('CODE_NAME')
            ]);
    }

    public function getModuleDir(): string
    {
        return plugin_dir_path($this->reflector->getFileName());
    }

    public function getTemplatesDir(): string
    {
        return $this->getModuleDir() . 'Templates';
    }

    public function getLogDir()
    {
        $dir = implode(DIRECTORY_SEPARATOR, [
            $this->getModuleDir(),
            'log',
        ]);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    public function getPluginUrl()
    {
        return plugin_dir_url($this->getPluginFile());
    }

    public function getPluginFile(): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            $this->getPluginDir(),
            $this->reflector->getConstant('CODE_NAME') . '.php'
        ]);
    }


}