<?php
namespace NiceModules\Core\Annotation;
/**
 * @Annotation 
 */
class FieldList
{
    public string $title;
    public string $order;
    public int $perPage = 20;
}