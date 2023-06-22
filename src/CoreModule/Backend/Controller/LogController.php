<?php

namespace NiceModules\CoreModule\Backend\Controller;

use NiceModules\Core\Controller\CrudController;
use NiceModules\CoreModule\Model\Log;

class LogController extends CrudController
{
    protected string $modelClass = Log::class;
}