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
     * @var CrudField[]
     */
    public array $filters;
    
    /**
     * @var string[]
     */
    public array $headers;
    
    public array $translation;
    
    public array $uris;
    
    public string $locale;
    
    protected string $class;

    public function __construct($modelClassName)
    {
        $this->class = $modelClassName;
        $translationInstance = new CrudTranslation();
        $this->translation = $translationInstance->get();
        $this->locale = str_replace('_', '-', Context::instance()->getLang()->getLocale());
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
    
    public function addUri($method, $uri){
        $this->uris[$method] = $uri;
    }

    /**
     * @param CrudField[] $filters
     */
    public function setFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    /**
     * @return CrudField[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}