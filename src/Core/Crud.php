<?php

namespace NiceModules\Core;

use NiceModules\Core\Annotations\FieldList;

class Crud
{
    protected FieldList $fieldList;
    /**
     * @var Rows[]
     */
    protected array $rows;
}