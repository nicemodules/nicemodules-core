<?php

namespace NiceModules\CoreModule\Model;

use NiceModules\Core\Model;
use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Table;

/**
 * @Table(
 *     type="Entity",
 *     name="log",
 *     allow_schema_update = true,
 *     repository="NiceModules\CoreModule\Repository\LogRepository",
 *     inherits="NiceModules\Core\Model"
 *     )
 */
class Log extends Model
{
    /**
     * @Column(type="text")
     */
    protected string $data;
}