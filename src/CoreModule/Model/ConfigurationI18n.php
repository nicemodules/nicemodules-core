<?php

namespace NiceModules\CoreModule\Model;

use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Table;

/**
 * @Table(
 *     type="Entity",
 *     name="configuration_i18n",
 *     allow_schema_update=true,
 *     indexes={
 *      @Index(name="language_index",  columns={"language"}),
 *      },
 *     repository="NiceModules\CoreModule\Nodel\ConfigurationI18nRepository",
 *     inherits="NiceModules\Core\Model\I18nModel",
 *     )
 */
class ConfigurationI18n
{
    /**
     * @Column(
     *     type="int",
     *     length="10",
     *     null="NOT NULL",
     *     many_to_one=@ManyToOne(modelName="NiceModules\ORM\Models\Test\Configuration", propertyName="ID", onDelete="CASCADE")
     *     )
     */
    protected int $object_id;

    /**
     * @Column(type="varchar", length="25")
     * @var string
     */
    protected string $language;

    /**
     * @Column(type="varchar", length=100)
     */
    protected ?string $catalogue;

    /**
     * @Column(type="varchar", length=150)
     */
    protected ?string $description;

}