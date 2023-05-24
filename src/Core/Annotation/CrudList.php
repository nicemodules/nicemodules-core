<?php

namespace NiceModules\Core\Annotation;

/**
 * @Annotation
 */
class CrudList
{
    public string $title;
    /**
     * @var CrudOrder[]
     */
    public array $order;
    public int $perPage = 20;
    public int $page = 1;


    public function getOffset()
    {
        return ($this->page - 1) * $this->perPage;
    }
}