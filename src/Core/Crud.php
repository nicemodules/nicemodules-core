<?php

namespace NiceModules\Core;

use NiceModules\Core\Annotation\CrudAction;
use NiceModules\Core\Annotation\CrudField;
use NiceModules\Core\Annotation\CrudOptions;
use NiceModules\Core\Crud\CrudTranslation;
use NiceModules\CoreModule\Model\Language;

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
    public array $selectedLanguage;
    public CrudAction $languageAction;
    /**
     * @var Language[]
     */
    public array $languages = [];

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
     * @param $property
     * @return CrudField
     */
    public function getField($property): CrudField
    {
        return $this->fields[$property];
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

    public function addUri($method, $uri)
    {
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

    public function getFilter($proprety): CrudField
    {
        return $this->filters[$proprety];
    }

    /**
     * @param Language[] $languages
     */
    public function setLanguages(array $languages): void
    {
        $this->languages = $languages;
    }

    public function setSelectedLanguage(array $language)
    {
        $this->selectedLanguage = $language;
    }

    public function setLanguageAction(CrudAction $action)
    {
        $this->languageAction = $action;
    }
}