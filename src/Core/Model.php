<?php

namespace NiceModules\Core;

use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Table;
use NiceModules\ORM\Models\BaseModel;

/**
 * @Table(prefix = "nm_")
 */
abstract class Model extends BaseModel
{
    /**
     * @Column(type = "datetime", null = "NOT NULL")
     */
    protected string $date_add;

    /**
     * @Column(type = "timestamp", null = "NOT NULL")
     */
    protected string $date_update;

}