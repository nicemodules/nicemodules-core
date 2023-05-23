<?php

namespace NiceModules\Core\Crud;

use NiceModules\ORM\Models\BaseModel;

class Row
{
    public BaseModel $object;
    public array $fields;
}