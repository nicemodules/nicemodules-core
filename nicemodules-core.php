<?php
/**
 * @package nicemodules-core
 */
/*
Plugin Name: NiceModules Core Plugin
Plugin URI: https://devpoint.io/
Description: Micro framework - environment for NiceModules
Version: 1.0.0
Requires PHP: 7.4
Author: NiceModules
Author URI: https://nicemodules.pl/
License: WTFPL
Text Domain: NiceModules
*/

if (!defined('ABSPATH')) {
    die('Do not load directly');
}

require_once 'bootstrap.php';

function niceModulesCoreInstall(){
    $installer = new NiceModules\Core\Installer();
    $installer->addModel(NiceModules\CoreModule\Model\Config::class);
    $installer->addModel(NiceModules\CoreModule\Model\Log::class);
    $installer->installDatabase();
    $installer->logOutput();
}
