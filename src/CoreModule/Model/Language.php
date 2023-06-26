<?php

namespace NiceModules\CoreModule\Model;

use NiceModules\Core\Annotation\CrudField;
use NiceModules\Core\Annotation\CrudOptions;
use NiceModules\Core\Annotation\CrudItemAction;
use NiceModules\Core\Annotation\CrudTopButtonAction;
use NiceModules\Core\Model;
use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Index;
use NiceModules\ORM\Annotations\Table;

/**
 * @CrudOptions(
 *     title="Log", 
 *     sortBy={"name"},
 *     itemActions={
 *      @CrudItemAction(name="edit", color="primary", icon="mdi-pencil"),
 *      @CrudItemAction(name="delete", color="red", icon="mdi-delete", confirm="Are you sure you want to delete this?")
 *      },
 *     topButtonActions={
 *      @CrudTopButtonAction(name="edit", label="Add", icon="mdi-plus-circle-outline")
 *      },
 *     )
 * 
 * @Table(
 *     type="Entity",
 *     name="language",
 *     allow_schema_update = true,
 *     indexes={
 *      @Index(name="shortcut_idx", columns={"shortcut"}),
 *      },
 *     repository="NiceModules\CoreModule\Repository\LanguageRepository",
 *     inherits="NiceModules\Core\Model"
 *     )
 */
class Language extends Model
{
    /**
     * @Column(type="varchar", length="50")
     * @CrudField(label="Language", type="text", filterable=false)
     */
    protected ?string $name;

    /**
     * @Column(type="varchar", length="50")
     * @CrudField(label="Shortcut", type="select", editable=true, filterable=false)
     */
    protected string $shortcut;

    /**
     * @Column(type="boolean", default="FALSE")
     * @CrudField(label="Active", type="checkbox", editable=true, filterable=false)
     */
    protected bool $active;

    /**
     * @Column(type="varchar", length="10")
     * @CrudField(label="Flag", type="flag-icon", editable=false, filterable=false)
     */
    protected ?string $flag;
    
}