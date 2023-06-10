<?php

namespace NiceModules\Core;

use NiceModules\Core\Annotation\CrudField;
use NiceModules\Core\Annotation\CrudOptions;
use NiceModules\Core\Crud\CrudTranslation;
use NiceModules\ORM\Manager;
use NiceModules\ORM\Models\BaseModel;

class Crud
{
    public CrudOptions $options;
    /**
     * @var CrudField[]
     */
    public array $fields;
    /**
     * @var string[]
     */
    public array $headers;
    
    public array $translation;
    
    protected string $class;

    public function __construct($modelClassName)
    {
        $this->class = $modelClassName;
        $translationInstance = new CrudTranslation();
        $this->translation = $translationInstance->get();
    }

    /**
     * @return CrudOptions
     */
    public function getOptions(): CrudOptions
    {
        return $this->CrudOptions;
    }

    /**
     * @param CrudOptions $options
     * @return Crud
     */
    public function setOptions(CrudOptions $options): Crud
    {
        $this->CrudOptions = $options;
        return $this;
    }

    /**
     * @return CrudField[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param CrudField[] $fields
     * @return Crud
     */
    public function setFields(array $fields): Crud
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * TODO: Retrieve session saved json with user crud parameters
     * Modifying properties of FieldList object (filters, order by, order direction, per page, page number etc. )
     */
    public function setUserParams()
    {
    }


    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param string[] $headers
     * @return Crud
     */
    public function setHeaders(array $headers): Crud
    {
        $this->headers = $headers;
        return $this;
    }
}