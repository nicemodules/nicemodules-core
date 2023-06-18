<?php

namespace NiceModules\Core\Model;

use NiceModules\Core\Annotation\CrudField;
use NiceModules\Core\Annotation\CrudOptions;
use NiceModules\Core\Model;
use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Index;
use NiceModules\ORM\Annotations\Table;

/**
 * @CrudOptions(title="Log", sortBy={"date_add"}, sortDesc={true})
 * 
 * @Table(
 *     type="Entity",
 *     name="log",
 *     allow_schema_update = true,
 *     indexes={
 *      @Index(name="type_idx", columns={"type"}),
 *      @Index(name="source_idx", columns={"source"})
 *      },
 *     repository="NiceModules\Core\Repository\LogRepository",
 *     inherits="NiceModules\Core\Model"
 *     )
 */
class Log extends Model
{

    /**
     * @Column(type="datetime", null="NOT NULL")
     * @CrudField(label="Added", type="date_time", editable=false)
     */
    protected string $date_add;

    /**
     * @Column(type="varchar", length="20")
     * @CrudField(label="Type", type="select", editable=false, options={"message", "ERROR", "WARNING"})
     */
    protected string $type;

    /**
     * @Column(type="varchar", length="255")
     * @CrudField(label="Source", type="text", editable=false)
     */
    protected string $source;

    /**
     * @Column(type="text")
     * @CrudField(label="Data", type="text", editable=false)
     */
    protected string $data;


}