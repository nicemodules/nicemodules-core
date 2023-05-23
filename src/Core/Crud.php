<?php

namespace NiceModules\Core;

use NiceModules\Core\Annotation\Field;
use NiceModules\Core\Annotations\FieldList;
use NiceModules\ORM\Models\BaseModel;

class Crud
{
    protected FieldList $fieldList;
    /**
     * @var Field[]
     */
    protected array $fields;
    /**
     * @var string[]
     */
    protected array $headers;
    /**
     * @var BaseModel[]
     */
    protected array $objects;

    /**
     * @param FieldList $fieldList
     * @return Crud
     */
    public function setFieldList(FieldList $fieldList): Crud
    {
        $this->fieldList = $fieldList;
        return $this;
    }

    /**
     * @return FieldList
     */
    public function getFieldList(): FieldList
    {
        return $this->fieldList;
    }

    /**
     * @param Field[] $fields
     * @return Crud
     */
    public function setFields(array $fields): Crud
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return Field[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }


    /**
     * TODO: Retrieve session saved json with user crud parameters 
     * Modifying properties of FieldList object (filters, order by, order direction, per page, page number etc. )
     */
    public function setUserParams(){
        
    }
    
    /**
     * TODO: Use orm for build query and get objects array 
     */
    public function  setObjects(){
        
    }
}