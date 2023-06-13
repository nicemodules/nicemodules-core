<?php

namespace NiceModules\CoreModule\Model;

use NiceModules\Core\Annotation\CrudField;
use NiceModules\Core\Annotation\CrudOptions;
use NiceModules\Core\Model;
use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Index;
use NiceModules\ORM\Annotations\Table;

/**
 * @CrudOptions(title="Configuration" , sortBy={"ID"})
 *
 * @Table(
 *     type="Entity",
 *     name="config",
 *     allow_schema_update = true,
 *     indexes={
 *      @Index(name="name_idx", columns={"name"}),
 *      @Index(name="namespace_idx", columns={"namespace"})
 *      },
 *     repository="NiceModules\CoreModule\Repository\ConfigRepository",
 *     inherits="NiceModules\Core\Model"
 *     )
 */
class Config extends Model
{
    /**
     * @Column(type = "varchar", length = 25)
     * @CrudField(label="Catalogue", type="text")
     */
    protected string $namespace;

    /**
     * @Column(type="varchar", length = 25)
     * @CrudField(label="Name", type="text")
     */
    protected string $name;

    /**
     * @Column(type="varchar", length=100)
     * @CrudField(label="Variable", type="text")
     */
    protected string $label;

    /**
     * @Column(type="varchar", length=150)
     * @CrudField(label="Description", type="text")
     */
    protected string $description;

    /**
     * @Column(type="varchar", length=25)
     * @CrudField(label="Type", type="text")
     */
    protected string $type;

    /**
     * @Column(type="text")
     * @CrudField(label="Value", type="text")
     */
    protected string $value;

}