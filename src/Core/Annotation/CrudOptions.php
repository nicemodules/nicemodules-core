<?php

namespace NiceModules\Core\Annotation;

/**
 * @Annotation
 */
class CrudOptions
{
    public string $title;
    public string $lang = 'pl';
    /**
     * @var CrudOrder[]
     */
    public array $order;
    public int $itemsPerPage = 20;
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
    
}