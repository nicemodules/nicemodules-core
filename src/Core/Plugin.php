<?php

namespace NiceModules\Core;

use NiceModules\Core\Plugin\Resource;

abstract class Plugin
{
    protected array $resources = [];
    protected Router $router;
    protected ?string $content;
    protected Module $module;

    public function __construct(Module $module)
    {
        $this->initializeSession();
        $this->initializeRouter();
        $this->module = $module;
        Context::instance()->setActivePlugin($this);
    }

    abstract public function initialize();
    abstract protected function initializeSession();

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return Module
     */
    public function getModule(): Module
    {
        return $this->module;
    }

    /**
     * @param Resource $resource
     * @return Plugin
     */
    public function addResource(Resource $resource): Plugin
    {
        $this->resources[$resource->type][] = $resource;
        return $this;
    }

    /**
     * @return Resource[]
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function renderContent()
    {
        echo $this->content;
    }

    public function attachFiles()
    {
        if (isset($this->resources[Resource::TYPE_CSS])) {
            /** @var Resource $resource */
            foreach ($this->resources[Resource::TYPE_CSS] as $id => $resource) {
                wp_enqueue_style(
                    $this->module::CODE_NAME . '_style-' . $id,
                    $resource->file,
                    [],
                    $resource->addVersion ? $this->module::VERSION : null
                );
            }
        }


        if (isset($this->resources[Resource::TYPE_JS])) {
            /** @var Resource $resource */
            foreach ($this->resources[Resource::TYPE_JS] as $id => $resource) {
                wp_enqueue_script(
                    $this->module::CODE_NAME . '_style-' . $id,
                    $resource->file,
                    [],
                    $resource->addVersion ? $this->module::VERSION : null
                );
            }
        }
    }

    abstract protected function initializeRouter();

}