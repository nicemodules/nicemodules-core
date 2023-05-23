<?php
namespace NiceModules\Core\Annotations;
/**
 * @Annotation 
 */
class FieldList
{
    public string $title;
    public string $order;
    public int $perPage = 20;
}