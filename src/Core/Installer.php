<?php

namespace NiceModules\Core;

use NiceModules;
use Composer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use NiceModules\ORM\Mapper;

class Installer
{
    /**
     * TODO: composer install tests, implementation, usage 
     * @var string[]
     */
    protected array $models;

    public function installComposer()
    {
        putenv('COMPOSER_HOME=' . NICEMODULES_CORE_DIR . '/vendor/bin/composer');

        $input = new ArrayInput(array('command' => 'install'));
        $application = new Application();
        $application->setAutoExit(false); // prevent `$application->run` method from exitting the script
        $application->run($input);
    }


    public function installDatabase()
    {
        foreach ($this->models as $model) {
            Mapper::instance($model)->updateSchema();
        }
    }

    /**
     * @param string $model
     * @return Installer
     */
    public function addModel(string $model): Installer
    {
        $this->models[] = $model;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getModels(): array
    {
        return $this->models;
    }
}