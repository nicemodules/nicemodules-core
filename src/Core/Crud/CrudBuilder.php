<?php

namespace NiceModules\Core\Crud;

use Doctrine\Common\Annotations\AnnotationReader;
use NiceModules\Core\Annotation\CrudField;
use NiceModules\Core\Annotation\CrudList;
use NiceModules\Core\Crud;
use ReflectionClass;
use ReflectionException;


class CrudBuilder
{
    protected string $class;
    protected Crud $crud;
    protected AnnotationReader $reader;
    protected ReflectionClass $reflector;

    public function __construct(string $modelClassName)
    {
        $this->class = $modelClassName;
    }

    public function build(): CrudBuilder
    {
        $this->crud = new Crud($this->class);
        $this->mapAnnotations();
        $this->crud->setUserParams();
        $this->crud->setItems();

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
        $fieldList = $this->getReader()->getClassAnnotation($reflector, CrudList::class);

        $this->crud->setCrudList($fieldList);
        
        $fields = [];
        $headers = [];
        foreach ($reflector->getProperties() as $property) {
            // Get the annotations of this property.
            $field = $this->getPropertyAnnotations($reflector, $property->name);

            // Silently ignore properties that do not have the annotation
            if ($field && isset($field->type)) {
                // Register annotation 
                $fields[$property->name] = $field;
                $headers[] = new CrudHeader($field->label, $property->name, $field->sortable);
            }
        }

        $this->crud->setFields($fields);
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