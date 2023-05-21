<?php


namespace NiceModules\Core\Plugin;


use NiceModules;
use NiceModules\Core\Installer;
use NiceModules\Core\Module;
use NiceModules\Core\Plugin;
use NiceModules\Core\Router\BackendRouter;

abstract class BackendPlugin extends Plugin
{

    protected array $menuLinks = [];
    protected Installer $installer;


    public function __construct(Module $module)
    {
        parent::__construct($module);
        $this->installer = new Installer();
    }

    public function getInstaller(): Installer
    {
        return $this->installer;
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
     * @param MenuLink $link
     * @return BackendPlugin
     */
    public function addMenuLink(MenuLink $link): BackendPlugin
    {
        $this->menuLinks[$link->menuSlug] = $link;
        return $this;
    }

    /**
     * @return MenuLink[]
     */
    protected function getMenuLinks(): array
    {
        return $this->menuLinks;
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
    
    public function install(){
        $this->getInstaller()->installDatabase();
    }
}