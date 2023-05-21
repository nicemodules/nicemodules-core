<?php
/**
 * Initialization of WordPress environment and / or composer autoload, for phpunit tests.
 * Printing basic information.
 */

namespace NiceModules;

use NiceModules\Core\Module;

$wpLoad = realpath(
    implode(
        DIRECTORY_SEPARATOR,
        [
            __DIR__, // /
            '..', // /nicemodules-core
            '..', // /plugins
            '..', // /wp-content
            '..', // /root
            'wp-load.php'
        ]
    )
);

$vendorLoad = realpath(
    implode(
        DIRECTORY_SEPARATOR,
        [
            __DIR__, // /
            '..', // /nicemodules-core
            'vendor',
            'autoload.php'
        ]
    )
);

require_once($wpLoad);

print_r('Bootstrap include: ' . $wpLoad . PHP_EOL);

// if loaded with WordPress wp-load.php, no need to include composer autoload 
if (!class_exists('NiceModules\Core\Module')) {
    require_once($vendorLoad);
    print_r('Bootstrap include: ' . $vendorLoad . PHP_EOL);
}

print_r('PHP version: ' . phpversion() . PHP_EOL);
print_r('WordPress Version: ' . get_bloginfo('version') . PHP_EOL);
print_r('NiceModules-core Version: ' . Module::VERSION . PHP_EOL);
