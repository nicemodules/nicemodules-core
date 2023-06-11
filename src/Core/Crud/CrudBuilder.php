<?php

namespace NiceModules\Core\Crud;

use Doctrine\Common\Annotations\AnnotationReader;
use NiceModules\Core\Annotation\CrudField;
use NiceModules\Core\Annotation\CrudOptions;
use NiceModules\Core\Controller\CrudController;
use NiceModules\Core\Crud;
use ReflectionClass;
use ReflectionException;


class CrudBuilder
{
    protected string $class;
    protected Crud $crud;
    protected AnnotationReader $reader;
    protected ReflectionClass $reflector;
    protected CrudController $controller;

    public function __construct(CrudController $controller)
    {
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
        $fieldList = $this->getReader()->getClassAnnotation($reflector, CrudOptions::class);

        $this->crud->setOptions($fieldList);
        
        $fields = [];
        $filters = [];
        $headers = [];
        foreach ($reflector->getProperties() as $property) {
            // Get the annotations of this property.
            $field = $this->getPropertyAnnotations($reflector, $property->name);

            // Silently ignore properties that do not have the annotation
            if ($field && isset($field->type)) {
                $field->name = $property->name;
                
                // Register annotation 
                if($field->editable){
                    $fields[$property->name] = $field;    
                }
                
                if($field->filterable){
                    $filters[$property->name] = $field;    
                }
                
                
                $headers[] = new CrudHeader($field->label, $property->name, $field->type, $field->sortable);
            }
        }

        $this->crud->setFields($fields);
        $this->crud->setFilters($filters);
        $this->crud->setHeaders($headers);
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