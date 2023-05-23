<?php
namespace NiceModules\Core\Annotation;

use NiceModules\ORM\Models\BaseModel;

/**
 * @Annotation
 */
class Field
{
    const TYPE_TEXT = 'text';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_RADIO = 'radio';
    const TYPE_SELECT = 'select';
    const TYPE_DATE = 'date';
    const TYPE_DATE_TIME = 'date_time';
    
    public string $label;
    public string $type;
    public string $value;
    public bool $editable = true;
    public bool $filterable = true;
    public bool $sortable = true;
    
    public array $subFields = [];
}