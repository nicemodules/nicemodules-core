<?php

namespace NiceModules\Core\Controller;

use NiceModules\Core\Model\Log;

class LogController extends CrudController
{
    protected string $modelClass = Log::class;
}