<?php

namespace NiceModules\Core;

use NiceModules\CoreModule\CoreModule;
use stdClass;

class Bootstrap
{
    protected string $file;
    protected stdClass $config;

    public function __construct()
    {
        $this->file = CoreModule::instance()->getDataDir() . DIRECTORY_SEPARATOR . 'bootstrap.json';

        $defaults = new stdClass();
        $defaults->log_errors = true;
        $defaults->timezone = 'Europe/Warsaw';

        if (!file_exists($this->file)) {
            file_put_contents($this->file, json_encode($defaults, JSON_PRETTY_PRINT));
        }

        $this->config = json_decode(file_get_contents($this->file));
    }

    public function initialize()
    {
        if ($this->config->log_errors) {
            ini_set(
                'error_log',
                CoreModule::instance()->getLogDir() . DIRECTORY_SEPARATOR . date('Y-m-d') . '_errors.log'
            );
        }

        date_default_timezone_set($this->config->timezone);
    }
}