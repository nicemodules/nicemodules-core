<?php

namespace NiceModules\Core\Crud;

use Doctrine\Common\Annotations\AnnotationReader;
use NiceModules\Core\Annotation\Field;
use NiceModules\Core\Annotation\FieldList;
use NiceModules\Core\Crud;
use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Table;
use NiceModules\ORM\Manager;
use PhpParser\Node\Expr\List_;

class CrudBuilder
{
    protected string $class;
    protected Crud $crud;
    protected AnnotationReader $reader;
    /**
     * @var Field[]
     */
    protected array $fields;
    protected ReflectionClass $reflector;

    public function __construct(string $modelClassName)
    {
        $this->class = $modelClassName;
    }
    
    public function build(){
        $this->crud = new Crud();
        $this->mapAnnotations();
        $this->crud->setFields($this->fields);
        $this->crud->setUserParams();
        $this->crud->setObjects();
    }

    /**
     * @return Crud
     */
    public function getCrud(): Crud
    {
        return $this->crud;
    }

    protected function mapAnnotations(){
        $reflector = $this->getReflector();
        
        // Get the annotation reader instance
        $fieldList = $this->getReader()->getClassAnnotation($reflector, FieldList::class);
        
        $this->crud->setFieldList($fieldList);

        foreach ($reflector->getProperties() as $property) {
            // Get the annotations of this property.
            $field = $this->getPropertyAnnotations($reflector, $property->name);

            // Silently ignore properties that do not have the annotation
            if ($field) {
                // Register annotation 
                $this->fields[$property->name] = $field;
            }
        }
    }

    /**
     * @param ReflectionClass $reflector
     * @param $propertyName
     * @return Column|null
     * @throws ReflectionException
     */
    private function getPropertyAnnotations(ReflectionClass $reflector, $propertyName): ?Field
    {
        $property = $reflector->getProperty($propertyName);
        return $this->getReader()->getPropertyAnnotation($property, Field::class);
    }
    
    protected function getReader(): AnnotationReader
    {
        if (!isset($this->reader)) {
            $this->reader = new AnnotationReader();
        }

        return $this->reader;
    }

    protected function getReflector()
    {
        if(!isset($this->reflector)){
            $this->reflector  = new ReflectionClass($this->class);    
        }
        
        return $this->reflector;
    }

   
}