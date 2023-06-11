<?php

namespace NiceModules\Core\Plugin;

use NiceModules\Core\Context;

class MenuLink
{
    public string $pageTitle;
    public string $menuTitle;
    public string $capability;
    public string $menuSlug;
    public ?MenuLink $parent;

    /**
     * @param string $menuTitle
     * @param string $pageTitle
     * @param string $capability
     * @param string $menuSlug
     * @param MenuLink|null $parent
     */
    public function __construct(
        string $menuTitle,
        string $pageTitle,
        string $menuSlug,
        ?MenuLink $parent = null,
        string $capability = 'edit_posts'
    ) {
        $l =  Context::instance()->getLang();
        
        $this->pageTitle = $l->get($pageTitle);
        $this->menuTitle =  $l->get($menuTitle);
        $this->menuSlug = $menuSlug;
        $this->parent = $parent;
        $this->capability = $capability;
    }
}