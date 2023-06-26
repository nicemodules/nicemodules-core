<?php

namespace NiceModules\Core\Annotation;

use NiceModules\Core\Context;

/**
 * @Annotation
 */
class CrudField
{
    const TYPE_TEXT = 'text';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_RADIO = 'radio';
    const TYPE_SELECT = 'select';
    const TYPE_DATE = 'date';
    const TYPE_DATE_TIME = 'date-time';

    public string $label;
    public string $name;
    public string $type;
    public bool $required = false;
    public bool $editable = false;
    public bool $filterable = true;
    public bool $sortable = true;
    public array $options = [];
    public $value;

    public array $subFields = [];
}