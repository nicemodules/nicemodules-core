<?php

namespace NiceModules\Core;

use Exception;

class Template
{
    protected string $templateDir;
    protected string $file;
    protected array $params;

    /**
     * @param string $file
     * @param array $params
     */
    public function __construct(string $file, array $params = [])
    {
        $this->templateDir = Context::instance()->getActivePlugin()->getModule()->getTemplatesDir();
        $this->file = $file;
        $this->params = $params;
        $this->setParam('_template', $this);
    }

    /**
     * @throws Exception
     */
    public function render(): void
    {
        if (!file_exists($this->getFile())) {
            throw new Exception('Template file does not exist ' . $this->getFile());
        }

        extract($this->params);

        include $this->getFile();
    }

    /**
     * @param $name
     * @param $value
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->templateDir . DIRECTORY_SEPARATOR . $this->file . '.php';
    }

    /**
     * @return string
     */
    public function getTemplateDir(): string
    {
        return $this->templateDir;
    }

    /**
     * @param string $file
     * @return Template
     */
    public function setFile(string $file): Template
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @param string $templateDir
     * @return Template
     */
    public function setTemplateDir(string $templateDir): Template
    {
        $this->templateDir = $templateDir;
        return $this;
    }

    /**
     * @param array $params
     * @return Template
     */
    public function setParams(array $params): Template
    {
        $this->params = $params;
        return $this;
    }
}