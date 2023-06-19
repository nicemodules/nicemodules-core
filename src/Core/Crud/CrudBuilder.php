<?php

namespace NiceModules\Core\Crud;

use Doctrine\Common\Annotations\AnnotationReader;
use NiceModules\Core\Annotation\CrudField;
use NiceModules\Core\Annotation\CrudOptions;
use NiceModules\Core\Context;
use NiceModules\Core\Controller\CrudController;
use NiceModules\Core\Crud;
use NiceModules\Core\I18n\InterfaceI18n;
use ReflectionClass;
use ReflectionException;


class CrudBuilder
{
    protected string $class;
    protected Crud $crud;
    protected AnnotationReader $reader;
    protected ReflectionClass $reflector;
    protected CrudController $controller;
    protected InterfaceI18n $interfaceI18n;


    public function __construct(CrudController $controller)
    {
        $this->interfaceI18n = Context::instance()->getInterfaceTranslator();
        $this->class = $controller->getModelClass();
        $this->controller = $controller;
    }

    public function build(): CrudBuilder
    {
        $this->crud = new Crud($this->class);
        $this->mapAnnotations();
        $this->crud->setUserParams();

        return $this;
    }

    /**
     * @return Crud
     */
    public function getCrud(): Crud
    {
        return $this->crud;
    }

    protected function mapAnnotations()
    {
        $reflector = $this->getReflector();

        // Get the annotation reader instance
        $options = $this->getReader()->getClassAnnotation($reflector, CrudOptions::class);

        // Set crud options
        $options->title = $this->interfaceI18n->get($options->title);

        $this->processItemActions($options->itemActions);
        $this->processTopButtonActions($options->topButtonActions);
        $this->processBulkActions($options->bulkActions);

        $fields = [];
        $filters = [];
        $headers = [];

        foreach ($reflector->getProperties() as $property) {
            // Get the annotations of this property.
            $field = $this->getPropertyAnnotations($reflector, $property->name);

            // Silently ignore properties that do not have the annotation
            if ($field && isset($field->type)) {
                // Translate label
                $field->label = $this->interfaceI18n->get($field->label);

                $field->name = $property->name;

                // Register annotation 
                if ($field->editable) {
                    $fields[$property->name] = $field;
                }

                if ($field->filterable) {
                    $filters[$property->name] = $field;
                }

                $headers[] = new CrudHeader($field->label, $property->name, $field->type, $field->sortable);
            }
        }


        if ($fields) {
            $headers[] = new CrudHeader('', 'actions', 'actions', false);
        }

        if ($options->bulkActions) {
            $options->bulk = true;
        }

        $this->crud->setOptions($options);
        $this->crud->setFields($fields);
        $this->crud->setFilters($filters);
        $this->crud->setHeaders($headers);
    }

    protected function processItemActions(array $itemActions)
    {
        foreach ($itemActions as $itemAction) {
            $itemAction->uri = $this->controller->getAjaxUri($itemAction->name);

            if (isset($itemAction->confirm) && $itemAction->confirm) {
                $itemAction->confirm = $this->interfaceI18n->get($itemAction->confirm);
                $itemAction->label = $this->interfaceI18n->get($itemAction->label);
            }
        }
    }

    protected function processTopButtonActions(array $topButtonActions)
    {
        foreach ($topButtonActions as $topButtonAction) {
            $topButtonAction->uri = $this->controller->getAjaxUri($topButtonAction->name);

            if (isset($topButtonAction->confirm) && $topButtonAction->confirm) {
                $topButtonAction->confirm = $this->interfaceI18n->get($topButtonAction->confirm);
                $topButtonAction->label = $this->interfaceI18n->get($topButtonAction->label);
            }
        }
    }

    protected function processBulkActions(array $bulkActions)
    {
        foreach ($bulkActions as $bulkAction) {
            $bulkAction->uri = $this->controller->getAjaxUri($bulkAction->name);

            if (isset($bulkAction->confirm) && $bulkAction->confirm) {
                $bulkAction->confirm = $this->interfaceI18n->get($bulkAction->confirm);
                $bulkAction->label = $this->interfaceI18n->get($bulkAction->label);
            }
        }
    }

    protected function getReader(): AnnotationReader
    {
        if (!isset($this->reader)) {
            $this->reader = new AnnotationReader();
        }

        return $this->reader;
    }

    /**
     * @throws ReflectionException
     */
    protected function getReflector()
    {
        if (!isset($this->reflector)) {
            $this->reflector = new ReflectionClass($this->class);
        }

        return $this->reflector;
    }

    /**
     * @param ReflectionClass $reflector
     * @param $propertyName
     * @return CrudField|null
     * @throws ReflectionException
     */
    private function getPropertyAnnotations(ReflectionClass $reflector, $propertyName): ?CrudField
    {
        $property = $reflector->getProperty($propertyName);
        return $this->getReader()->getPropertyAnnotation($property, CrudField::class);
    }


}