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


    public function __construct(array $values)
    {
        $lang = Context::instance()->getLang();
        
        foreach ($values as $name => $value) {
            switch ($name) {
                case 'title':
                    $this->$name = $lang->get($value);
                    break;
                default:
                    $this->$name = $value;
                    break;
            }
        }
    }
}