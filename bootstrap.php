<?php

namespace NiceModules;



use NiceModules\Core\Bootstrap;
use NiceModules\Core\Plugin\MenuLink;
use NiceModules\Core\Plugin\Resource;
use NiceModules\Core\Router\Route;
use NiceModules\CoreModule\Backend\Controller\ConfigurationController;
use NiceModules\CoreModule\Backend\Controller\LanguageController;
use NiceModules\CoreModule\Backend\Controller\LogController;
use NiceModules\CoreModule\Backend\CoreBackendPlugin;
use NiceModules\CoreModule\CoreModule;
use NiceModules\CoreModule\Frontend\Controller\TestingController;
use NiceModules\CoreModule\Frontend\CoreFrontendPlugin;

if (!defined('ABSPATH')) {
    die('Do not load directly');
}

require_once 'vendor/autoload.php';

$bootstrap = new Bootstrap();
$bootstrap->initialize();

if (is_admin()) {
    $coreAdminPlugin = new CoreBackendPlugin(CoreModule::instance());
    
    $router = $coreAdminPlugin->getRouter();

    // Define rotes
    $router
        ->addRoute(new Route('nm_language', LanguageController::class, 'list'))
        ->addRoute(new Route('nm_language_data', LanguageController::class, 'getItems', true))
        ->addRoute(new Route('nm_language_edit', LanguageController::class, 'edit', true))
        ->addRoute(new Route('nm_language_delete', LanguageController::class, 'delete', true))
    ;

    if (WP_DEBUG) {
        $router->addRoute(new Route('nm_config', ConfigurationController::class, 'list'))
            ->addRoute(new Route('nm_log', LogController::class, 'list'))
            ->addRoute(new Route('nm_log_data', LogController::class, 'getItems', true))
            ->addRoute(new Route('nm_log_clear', LogController::class, 'clearLog', true))
            ->addRoute(new Route('nm_index', LogController::class, 'list'))
            ->addRoute(new Route('nm_config_data', ConfigurationController::class, 'getItems', true))
            ->addRoute(new Route('nm_config_edit', ConfigurationController::class, 'edit', true))
            ->addRoute(new Route('nm_config_delete', ConfigurationController::class, 'delete', true))
            ->addRoute(new Route('nm_config_bulk_delete', ConfigurationController::class, 'bulkDelete', true))
            ;
    }
    
    // Add resources
    if(WP_DEBUG){
        $coreAdminPlugin
            ->addResource(new Resource(Resource::TYPE_CSS, 'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900', false))
            ->addResource(new Resource(Resource::TYPE_CSS, CoreModule::instance()->getPluginUrl().'css/backend/bundle.css'))
            ->addResource(new Resource(Resource::TYPE_JS, CoreModule::instance()->getPluginUrl().'js/backend/bundle.js'))
        ;
    }else{
        $coreAdminPlugin
            ->addResource(new Resource(Resource::TYPE_CSS, CoreModule::instance()->getPluginUrl().'css/backend/bundle.min.css'))
            ->addResource(new Resource(Resource::TYPE_CSS, 'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900', false))
            ->addResource(new Resource(Resource::TYPE_JS, CoreModule::instance()->getPluginUrl().'js/backend/bundle.min.js'))
        ;
    }
    
    // Define menu links
    $mainLink = new MenuLink('NiceModules', 'Config', 'nm_index');

    $coreAdminPlugin
        ->addMenuLink($mainLink)
        ->addMenuLink(new MenuLink('Config', 'Config', 'nm_config', $mainLink))
        ->addMenuLink(new MenuLink('Log', 'Log', 'nm_log', $mainLink))
        ->addMenuLink(new MenuLink('Languages', 'Languages', 'nm_language', $mainLink));
    
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