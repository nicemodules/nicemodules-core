<?php
namespace NiceModules\Core\Helper;

class WpHelper
{
    public static function detectFunctionUsage($functions): bool
    {
        if (!is_array($functions)) {
            return false;
        }

        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        foreach ($backtrace as $entry) {
            if (isset($entry['class']) && isset($entry['type']) && isset($entry['function'])) {
                $function = $entry['class'] . $entry['type'] . $entry['function'];

                if (in_array($function, $functions)) {
                    return true;
                }
            }
        }

        return false;
    }
}