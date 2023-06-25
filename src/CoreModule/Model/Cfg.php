<?php

namespace NiceModules\CoreModule\Model;

use NiceModules\Core\Model;
use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Table;

/**
 * Clear config model for retrieve values for Config class
 * 
 * @Table(
 *     type="Entity",
 *     name="config",
 *     allow_schema_update = false,
 *     repository="NiceModules\CoreModule\Repository\CfgRepository",
 *     inherits="NiceModules\Core\Model\I18nModel",
 *     )
 */
class Cfg extends Model
{
    /**
     * @Column(type = "varchar", length = 100)
     */
    protected ?string $namespace;

    /**
     * @Column(type="varchar", length=100)
     */
    protected ?string $catalogue;
    
    /**
     * @Column(type="varchar", length = 100)
     */
    protected ?string $name;

    /**
     * @Column(type="varchar", length=100)
     */
    protected ?string $label;

    /**
     * @Column(type="varchar", length=150)
     */
    protected ?string $description;

    /**
     * @Column(type="varchar", length=50)
     */
    protected ?string $type;

    /**
     * @Column(type="text")
     */
    protected ?string $value;

}