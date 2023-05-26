<?php

namespace NiceModules\Core;

use Composer\Console\Application;
use NiceModules;
use NiceModules\CoreModule\CoreModule;
use NiceModules\ORM\Mapper;
use ReflectionException;
use Symfony\Component\Console\Input\ArrayInput;

class Installer
{
    /**
     * TODO: composer install tests, implementation, usage
     * @var string[]
     */
    protected array $models;

    public function installComposer()
    {
        putenv('COMPOSER_HOME=' . CoreModule::instance()->getPluginDir() . '/vendor/bin/composer');

        $input = new ArrayInput(array('command' => 'install'));
        $application = new Application();
        $application->setAutoExit(false); // prevent `$application->run` method from exitting the script
        $application->run($input);
    }


    /**
     * Install added models
     * @throws NiceModules\ORM\Exceptions\AllowSchemaUpdateIsFalseException
     * @throws NiceModules\ORM\Exceptions\RepositoryClassNotDefinedException
     * @throws NiceModules\ORM\Exceptions\RequiredAnnotationMissingException
     * @throws NiceModules\ORM\Exceptions\UnknownColumnTypeException
     * @throws ReflectionException
     */
    public function installDatabase()
    {
        foreach ($this->models as $model) {
            Mapper::instance($model)->updateSchema();
        }
    }

    /**
     * Add model to update in the database
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

    /**
     * Write down the installation errors if they occur
     */
    public function logOutput()
    {
        $logFile = NiceModules\CoreModule\CoreModule::instance()->getLogDir() . DIRECTORY_SEPARATOR . 'install.log';

        $logContent = ob_get_contents();
        $logger = NiceModules\ORM\Logger::instance();

        if (NiceModules\ORM\Logger::instance()->isEnabled()) {
            $logContent .= PHP_EOL . 'ORM LOG ENABLED';
            $logContent .= PHP_EOL . 'ORM LOG MESSAGES: ' . count($logger->getLog());
            $logContent .= PHP_EOL . $logger->getLogString();
        }

        if (!empty($logContent)) {
            file_put_contents($logFile, $logContent);
        }
    }
}