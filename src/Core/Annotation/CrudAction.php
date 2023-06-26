<?php

namespace NiceModules\Core\Annotation;

class CrudAction
{
    /**
     * @var string - Actually name of crud controller method to handle action
     */
    public string $name = '';
    public string $type = '';
    public string $label = '';
    public string $icon = '';
    public string $color = 'default';
    public string $confirm = '';
    public string $uri;
}