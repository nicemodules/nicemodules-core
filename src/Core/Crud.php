<?php

namespace NiceModules\Core;

use NiceModules\Core\Annotation\CrudField;
use NiceModules\Core\Annotation\CrudList;
use NiceModules\ORM\Manager;
use NiceModules\ORM\Models\BaseModel;

class Crud
{
    public CrudList $CrudList;
    /**
     * @var CrudField[]
     */
    public array $fields;
    /**
     * @var string[]
     */
    public array $headers;
    /**
     * @var BaseModel[]
     */
    public array $items;

    protected string $class;

    public function __construct($modelClassName)
    {
        $this->class = $modelClassName;
    }

    /**
     * @return CrudList
     */
    public function getCrudList(): CrudList
    {
        return $this->CrudList;
    }

    /**
     * @param CrudList $CrudList
     * @return Crud
     */
    public function setCrudList(CrudList $CrudList): Crud
    {
        $this->CrudList = $CrudList;
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

    public function setItems()
    {
        $queryBuilder = Manager::instance()->getRepository($this->class)->createQueryBuilder();

        $queryBuilder->limit($this->CrudList->perPage, $this->CrudList->getOffset());

        if(isset($this->CrudList->order)){
            foreach ($this->CrudList->order as $order) {
                $queryBuilder->orderBy($order->column, $order->direction);
            }    
        }
        $queryBuilder->buildQuery();

        $this->items = $queryBuilder->getResultArray();
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

    /**
     * @return BaseModel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}