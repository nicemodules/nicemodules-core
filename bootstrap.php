<?php

namespace NiceModules;

use NiceModules\Core\Plugin\MenuLink;
use NiceModules\Core\Router\Route;
use NiceModules\CoreModule\Frontend\Controller\TestingController;
use NiceModules\CoreModule\Backend\Controller\ConfigController;
use NiceModules\CoreModule\Backend\Controller\LogController;
use NiceModules\CoreModule\Backend\CoreBackendPlugin;
use NiceModules\CoreModule\Frontend\CoreFrontendPlugin;
use NiceModules\CoreModule\CoreModule;
use NiceModules\Model\Config;
use NiceModules\Model\Log;

if (!defined('ABSPATH')) {
    die('Do not load directly');
}

define('NICEMODULES_CORE_DIR', __DIR__);
define('MODULE_URL', plugin_dir_url(__FILE__));
define('DATA_DIR', NICEMODULES_CORE_DIR . DIRECTORY_SEPARATOR . 'data');
define('TEMPLATE_DIR', NICEMODULES_CORE_DIR . DIRECTORY_SEPARATOR . 'templates');

require_once 'vendor/autoload.php';

if (is_admin()) {
    
    $coreAdminPlugin = new CoreBackendPlugin(CoreModule::instance());

    // Update models on install
    $coreAdminPlugin->getInstaller()
        ->addModel(Config::class)
        ->addModel(Log::class);

    // Define rotes
    $router = $coreAdminPlugin->getRouter();

    $router->addRoute(new Route('nm_config',ConfigController::class,'list'))
        ->addRoute(new Route('nm_config_save',ConfigController::class,'listSave', true))
        ->addRoute(new Route('nm_log',LogController::class,'list'))
        ->addRoute(new Route('nm_log_save',LogController::class,'logSave', true))
        ->addRoute(new Route('nm_index',ConfigController::class,'list'))
       ;

    // Define menu links
    $mainLink = new MenuLink('NiceModules','Config','nm_index');
    
    $coreAdminPlugin
        ->addMenuLink($mainLink)
        ->addMenuLink(new MenuLink('Config','Config','nm_config', $mainLink))
        ->addMenuLink(new MenuLink('Log','Log','nm_log', $mainLink));

    // Register admin functions 
    register_activation_hook(__FILE__, [$coreAdminPlugin, 'install']);
    add_action('init', [$coreAdminPlugin, 'initialize']);
    add_action('admin_menu', [$coreAdminPlugin, 'initializeMenu']);
} else {
    $frontendPlugin = new CoreFrontendPlugin(CoreModule::instance());
    
    $router = $frontendPlugin->getRouter();

    $router->addRoute(new Route('nice-modules-testing',TestingController::class,'index'));

    // Frontend functions
    add_action('init', [$frontendPlugin, 'initialize']);
}

