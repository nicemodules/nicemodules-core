<?php

namespace NiceModules\CoreModule\Model;

use NiceModules\Core\Model;
use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Table;
use NiceModules\ORM\Annotations\Index;
use NiceModules\ORM\Annotations\ManyToOne;

/**
 * @Table(
 *     type="Entity",
 *     name="config_i18n",
 *     allow_schema_update=true,
 *     indexes={
 *      @Index(name="language_index",  columns={"language"}),
 *      },
 *     repository="NiceModules\CoreModule\Repository\ConfigurationI18nRepository",
 *     inherits="NiceModules\Core\Model",
 *     )
 */
class ConfigurationI18n extends Model
{
    /**
     * @Column(
     *     type="int",
     *     length="10",
     *     null="NOT NULL",
     *     many_to_one=@ManyToOne(modelName="NiceModules\CoreModule\Model\Configuration", propertyName="ID", onDelete="CASCADE")
     *     )
     */
    protected int $object_id;

    /**
     * @Column(type="varchar", length="5")
     * @var string
     */
    protected string $language;

    /**
     * @Column(type="varchar", length=100)
     */
    protected ?string $catalogue;

    /**
     * @Column(type="varchar", length=100, custom={"i18n":true})
     */
    protected ?string $label;
    
    /**
     * @Column(type="varchar", length=150)
     */
    protected ?string $description;

}