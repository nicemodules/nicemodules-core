<?php

namespace NiceModules\CoreModule\Model;

use NiceModules\Core\Annotation\CrudBulkAction;
use NiceModules\Core\Annotation\CrudField;
use NiceModules\Core\Annotation\CrudItemAction;
use NiceModules\Core\Annotation\CrudOptions;
use NiceModules\Core\Annotation\CrudTopButtonAction;
use NiceModules\Core\Model\i18nModel;
use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Index;
use NiceModules\ORM\Annotations\Table;

/**
 * @CrudOptions(
 *     title="Configuration values",
 *     sortBy={"ID"},
 *     itemActions={
 *      @CrudItemAction(name="edit", color="primary", icon="mdi-pencil"),
 *      @CrudItemAction(name="delete", color="red", icon="mdi-delete", confirm="Are you sure you want to delete this?")
 *      },
 *     topButtonActions={
 *      @CrudTopButtonAction(name="edit", label="Add", icon="mdi-plus-circle-outline")
 *      },
 *     bulkActions={
 *      @CrudBulkAction(name="bulkDelete", label="Delete", icon="mdi-delete", color="red lighten-4", confirm="Are you sure you want to delete this?")
 *      }
 *     )
 *
 * @Table(
 *     type="Entity",
 *     name="config",
 *     allow_schema_update = true,
 *     indexes={
 *      @Index(name="name_idx", columns={"name"}),
 *      @Index(name="namespace_idx", columns={"namespace"})
 *      },
 *     repository="NiceModules\CoreModule\Repository\ConfigurationRepository",
 *     inherits="NiceModules\Core\Model\I18nModel",
 *     custom={"i18n":true, "i18nModel":"NiceModules\CoreModule\Model\ConfigurationI18n"}
 *     )
 */
class Configuration extends i18nModel
{
    /**
     * @Column(type = "varchar", length = 100)
     * @CrudField(label="Namespace", type="text", editable=true)
     */
    protected ?string $namespace;

    /**
     * @Column(type="varchar", length=100, custom={"i18n":true})
     * @CrudField(label="Catalogue", type="text", editable=true)
     */
    protected ?string $catalogue;
    
    /**
     * @Column(type="varchar", length = 100)
     * @CrudField(label="Name", type="text", editable=true)
     */
    protected ?string $name;

    /**
     * @Column(type="varchar", length=100, custom={"i18n":true})
     * @CrudField(label="Label", type="text", editable=true)
     */
    protected ?string $label;

    /**
     * @Column(type="varchar", length=150, custom={"i18n":true})
     * @CrudField(label="Description", type="text", editable=true)
     */
    protected ?string $description;

    /**
     * @Column(type="varchar", length=50)
     * @CrudField(label="Type", type="text", editable=true)
     */
    protected ?string $type;

    /**
     * @Column(type="text")
     * @CrudField(label="Value", type="text", editable=true)
     */
    protected ?string $value;

}