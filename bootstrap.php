<?php

namespace NiceModules;

use NiceModules\Core\Plugin\MenuLink;
use NiceModules\Core\Plugin\Resource;
use NiceModules\Core\Router\Route;
use NiceModules\CoreModule\Backend\Controller\ConfigController;
use NiceModules\CoreModule\Backend\Controller\LogController;
use NiceModules\CoreModule\Backend\CoreBackendPlugin;
use NiceModules\CoreModule\CoreModule;
use NiceModules\CoreModule\Frontend\Controller\TestingController;
use NiceModules\CoreModule\Frontend\CoreFrontendPlugin;

if (!defined('ABSPATH')) {
    die('Do not load directly');
}

require_once 'vendor/autoload.php';

if (is_admin()) {
    $coreAdminPlugin = new CoreBackendPlugin(CoreModule::instance());

    // Define rotes
    $router = $coreAdminPlugin->getRouter();

    // Add stylesheets
    $coreAdminPlugin
        ->addResource(new Resource(Resource::TYPE_CSS, 'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900', false))
        ->addResource(new Resource(Resource::TYPE_CSS, CoreModule::instance()->getPluginUrl().'css/materialdesignicons.min.css'))
        ->addResource(new Resource(Resource::TYPE_CSS, CoreModule::instance()->getPluginUrl().'css/vuetify.min.css'));
 
    // Add js
    if(WP_DEBUG){
        $coreAdminPlugin->addResource(new Resource(Resource::TYPE_JS, CoreModule::instance()->getPluginUrl().'js/vue.js'));
    }else{
        $coreAdminPlugin->addResource(new Resource(Resource::TYPE_JS, CoreModule::instance()->getPluginUrl().'js/vue.min.js'));
    }
    $coreAdminPlugin->addResource(new Resource(Resource::TYPE_JS, CoreModule::instance()->getPluginUrl().'js/vuetify.js'));

    $router->addRoute(new Route('nm_config', ConfigController::class, 'list'))
        ->addRoute(new Route('nm_config_save', ConfigController::class, 'listSave', true))
        ->addRoute(new Route('nm_log', LogController::class, 'list'))
        ->addRoute(new Route('nm_log_save', LogController::class, 'logSave', true))
        ->addRoute(new Route('nm_index', ConfigController::class, 'list'));

    // Define menu links
    $mainLink = new MenuLink('NiceModules', 'Config', 'nm_index');

    $coreAdminPlugin
        ->addMenuLink($mainLink)
        ->addMenuLink(new MenuLink('Config', 'Config', 'nm_config', $mainLink))
        ->addMenuLink(new MenuLink('Log', 'Log', 'nm_log', $mainLink));
    
    // WpModule installation
    register_activation_hook(
        CoreModule::instance()->getPluginFile(),
        'niceModulesCoreInstall'
    );

    // Admin functions
    add_action('init', [$coreAdminPlugin, 'initialize']);
    add_action('admin_menu', [$coreAdminPlugin, 'initializeMenu']);
} else {
    $frontendPlugin = new CoreFrontendPlugin(CoreModule::instance());

    $router = $frontendPlugin->getRouter();

    $router->addRoute(new Route('nice-modules-testing', TestingController::class, 'index'));

    // Frontend functions
    add_action('init', [$frontendPlugin, 'initialize']);
}