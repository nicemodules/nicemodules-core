<?php

namespace NiceModules\CoreModule\Backend\Controller;

use NiceModules\Core\Context;
use NiceModules\Core\Controller\CrudController;
use NiceModules\CoreModule\Model\Log;
use NiceModules\ORM\Exceptions\AllowSchemaUpdateIsFalseException;
use NiceModules\ORM\Exceptions\AllowTruncateIsFalseException;
use NiceModules\ORM\Exceptions\RepositoryClassNotDefinedException;
use NiceModules\ORM\Exceptions\RequiredAnnotationMissingException;
use NiceModules\ORM\Exceptions\UnknownColumnTypeException;
use NiceModules\ORM\Mapper;
use ReflectionException;
use Throwable;

class LogController extends CrudController
{
    protected string $modelClass = Log::class;

    /**
     * @throws AllowSchemaUpdateIsFalseException
     * @throws AllowTruncateIsFalseException
     * @throws RepositoryClassNotDefinedException
     * @throws RequiredAnnotationMissingException
     * @throws UnknownColumnTypeException
     * @throws ReflectionException
     * @throws Throwable
     */
    public function clearLog(){
        Mapper::instance($this->modelClass)->truncateTable();
        
        $this->setResponse(self::SUCCESS, Context::instance()->getInterfaceI18n()->get('The data has been deleted correctly'));
        $this->renderJsonResponse();
    }
    
}