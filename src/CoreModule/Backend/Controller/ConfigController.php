<?php

namespace NiceModules\CoreModule\Backend\Controller;


use NiceModules\Core\Controller\CrudController;
use NiceModules\CoreModule\Model\Configuration;


class ConfigController extends CrudController
{
    protected string $modelClass = Configuration::class;
}