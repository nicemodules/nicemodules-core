<?php

namespace NiceModules\Core\Plugin;

class MenuLink
{
    public string $pageTitle;
    public string $menuTitle ;
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
        $this->pageTitle = $pageTitle;
        $this->menuTitle = $menuTitle;
        $this->menuSlug = $menuSlug;
        $this->parent = $parent;
        $this->capability = $capability;
    }
}