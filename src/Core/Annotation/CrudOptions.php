<?php

namespace NiceModules\Core\Annotation;

use NiceModules\Core\Context;
use NiceModules\Core\Lang;

/**
 * @Annotation
 */
class CrudOptions
{
    public string $title;
    /**
     * @var CrudOrder[]
     */
    public array $order;
    public int $itemsPerPage = 10;
    public int $page = 1;
    /**
     * @var string[]
     */
    public array $sortBy;
    /**
     * @var bool[]
     */
    public array $sortDesc;
    public bool $multiSort = false;
    public bool $allowAdd = true; 
    public bool $allowDelete = true; 
}