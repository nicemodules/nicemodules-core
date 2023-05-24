<?php

namespace NiceModules\Core\Annotation;

class CrudOrder
{
    public string $column;
    public string $direction;

    public function __construct(array $values)
    {
        foreach ($values as $name => $value) {
            $this->$name = $value;
        }
    }
}