<?php


namespace NiceModules\Core\Plugin;


use NiceModules;
use NiceModules\Core\Config;
use NiceModules\Core\Installer;
use NiceModules\Core\Module;
use NiceModules\Core\Plugin;
use NiceModules\Core\Router\BackendRouter;
use NiceModules\Core\Session;

abstract class BackendPlugin extends Plugin
{
    protected array $menuLinks = [];
    protected Installer $installer;

    public function __construct(Module $module)
    {
        parent::__construct($module);
        
        $this->installer = new Installer();
    }
    
    protected function initializeSession()
    {
        if(Session::instance()->get('orm_language')){
            Session::instance()->set('orm_language', Config::instance('core')->get('orm_language'));
        }
        
    }

    public function getInstaller(): Installer
    {
        return $this->installer;
    }

    /**
     * @param MenuLink $link
     * @return BackendPlugin
     */
    public function addMenuLink(MenuLink $link): BackendPlugin
    {
        $this->menuLinks[$link->menuSlug] = $link;
        return $this;
    }

    public function initializeMenu()
    {
        $links = $this->getMenuLinks();

        foreach ($links as $link) {
            if ($link->parent) {
                add_submenu_page(
                    $link->parent->menuSlug,
                    $link->pageTitle,
                    $link->menuTitle,
                    $link->capability,
                    $link->menuSlug,
                    [$this, 'renderContent']
                );
            } else {
                add_menu_page(
                    $link->pageTitle,
                    $link->menuTitle,
                    $link->capability,
                    $link->menuSlug,
                    [$this, 'renderContent'],
                    $this->module::ICON,
                    4
                );
            }
        }
    }

    public function install()
    {
        $this->getInstaller()->installDatabase();
    }

    protected function initializeRouter()
    {
        $this->router = new BackendRouter();
    }

    public function initialize()
    {
        if ($this->content = $this->router->route()) {
            add_action('admin_enqueue_scripts', [$this, 'attachFiles']);

            if ($this->router->getRoute()->isAjax()) {
                add_action('wp_ajax_' . $this->router->getRoute()->getUri(), [$this, 'renderContent']);
            }
        }
    }

    /**
     * @return MenuLink[]
     */
    protected function getMenuLinks(): array
    {
        return $this->menuLinks;
    }
}