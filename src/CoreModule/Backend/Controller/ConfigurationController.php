<?php

namespace NiceModules\CoreModule\Backend\Controller;


use NiceModules\Core\Controller\I18nCrudController;
use NiceModules\CoreModule\Model\Configuration;


class ConfigurationController extends I18nCrudController
{
    protected string $modelClass = Configuration::class;
}