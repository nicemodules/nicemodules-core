<?php

namespace NiceModules\Core;

use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Table;
use NiceModules\ORM\Models\BaseModel;

/**
 * @Table(
 *     prefix = "nm",
 *     column_order={"ID", "date_add", "date_update"}
 *     )
 *
 */
abstract class Model extends BaseModel
{
    /**
     * @Column(type="datetime", null="NOT NULL")
     */
    protected string $date_add;

    /**
     * @Column(type="timestamp", null="NOT NULL", default="CURRENT_TIMESTAMP")
     */
    protected string $date_update;

    public function executeBeforeSave()
    {
        parent::executeBeforeSave();

        if (!$this->hasId()) { // is object new?
            $this->date_add = date('Y-m-d H:i:s');
        }
    }
}