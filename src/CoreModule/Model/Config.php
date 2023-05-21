<?php

namespace NiceModules\Model;

use NiceModules\Core\Model;
use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Index;
use NiceModules\ORM\Annotations\Table;

/**
 * @Table(
 *     type = "Entity",
 *     name = "config",
 *     allow_schema_update = true,
 *     index = @Index(name="name_index", columns={"name"}),
 *     inherits="NiceModules\Core\Model"
 *     )
 */
class Config extends Model
{
    /**
     * @Column(type = "varchar", length = 25)
     */
    protected string $namespace;

    /**
     * @Column(type="varchar", length = 25)
     */
    protected string $name;

    /**
     * @Column(type="varchar", length=100)
     */
    protected string $label;

    /**
     * @Column(type="varchar", length=150)
     */
    protected string $description;

    /**
     * @Column(type="varchar", length=25)
     */
    protected string $type;

    /**
     * @Column(type="text")
     */
    protected string $value;

}