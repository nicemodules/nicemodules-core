<?php

namespace NiceModules\Core;

abstract class Plugin
{
    protected array $styleFiles = [];
    protected array $javaScriptFiles = [];
    protected Router $router;
    protected ?string $content;
    protected Module $module;

    public function __construct(Module $module)
    {
        $this->initializeRouter();
        $this->module = $module;
        Context::instance()->setActivePlugin($this);
    }

    abstract public function initialize();

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    abstract protected function initializeRouter();

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function renderContent()
    {
        echo $this->content;
    }

    /**
     * @param string $styleUrl
     */
    public function addStyleFile(string $styleUrl): void
    {
        $this->styleFiles[] = $styleUrl;
    }

    /**
     * @return array
     */
    protected function getStyleFiles(): array
    {
        return $this->styleFiles;
    }

    /**
     * @param string $javaScriptUrl
     */
    public function addJavaScriptFile(string $javaScriptUrl): void
    {
        $this->javaScriptFiles[] = $javaScriptUrl;
    }

    /**
     * @return array
     */
    protected function getJavaScriptFiles(): array
    {
        return $this->javaScriptFiles;
    }

    public function attachFiles()
    {
        $styles = $this->getStyleFiles();

        foreach ($styles as $id => $file) {
            wp_enqueue_style($this->module::CODE_NAME . '_style-' . $id, $file, [], $this->module::VERSION);
        }

        $scripts = $this->getJavaScriptFiles();

        foreach ($scripts as $id => $file) {
            wp_enqueue_script($this->module::CODE_NAME . '_script-' . $id, $file, [], $this->module::VERSION);
        }
    }

}