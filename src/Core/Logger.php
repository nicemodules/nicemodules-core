<?php

namespace NiceModules\Core;

use NiceModules\Core\Model\Log;
use NiceModules\ORM\Manager;

class Logger
{
    const ERROR = 'ERROR';
    const MESSAGE = 'message';
    const WARNING = 'WARNING';

    /**
     * @param $something
     * @param string $source
     * @param string $type
     * @return mixed|null
     * @throws \NiceModules\ORM\Exceptions\FailedToInsertException
     * @throws \NiceModules\ORM\Exceptions\FailedToUpdateException
     * @throws \NiceModules\ORM\Exceptions\PropertyDoesNotExistException
     * @throws \NiceModules\ORM\Exceptions\RepositoryClassNotDefinedException
     * @throws \NiceModules\ORM\Exceptions\RequiredAnnotationMissingException
     * @throws \NiceModules\ORM\Exceptions\UnknownColumnTypeException
     * @throws \ReflectionException
     * @throws \Throwable
     */
    public static function add($something, $source = '',  $type = self::MESSAGE)
    {
        $something = print_r($something, 1);
        $entry = new Log();
        $entry->set('data', $something);
        $entry->set('type', $type);
        $entry->set('source', $source);

        Manager::instance()
            ->persist($entry)
            ->flush()
            ->clean($entry);
        
        return $entry->get('ID');
    }
}