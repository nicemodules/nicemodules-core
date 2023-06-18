<?php

namespace NiceModules\Core\Helper;

class VuetifyHelper
{
    public static function getSelectOptionsFromArray(array $items): array
    {
        $options = [];
        foreach ($items as $value => $name) {
            $options[] = ['value' => $value, 'name' => $name];
        }

        return $options;
    }
}