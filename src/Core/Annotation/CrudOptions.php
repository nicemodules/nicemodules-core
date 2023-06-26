<?php

namespace NiceModules\Core\Annotation;

/**
 * @Annotation
 */
class CrudOptions
{
    public string $title;
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
    public bool $bulk = false;
    public bool $i18n = false;
    
    /**
     * @var \NiceModules\Core\Annotation\CrudItemAction[]
     */
    public array $itemActions = [];

    /**
     * @var \NiceModules\Core\Annotation\CrudTopButtonAction[]
     */
    public array $topButtonActions = [];

    /**
     * @var \NiceModules\Core\Annotation\CrudBulkAction[]
     */
    public array $bulkActions = [];
}