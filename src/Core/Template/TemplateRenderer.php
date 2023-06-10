<?php

namespace NiceModules\Core\Template;

use NiceModules\Core\Template;

class TemplateRenderer
{
    protected string $content = '';
    /**
     * @var Template[]
     */
    protected array $templates;
    

    public function addTemplate(Template $template): TemplateRenderer
    {
        $template->setParam('_renderer', $this);

        $this->templates[] = $template;

        return $this;
    }

    public function render(): TemplateRenderer
    {
        ob_start();
        foreach ($this->templates as $template) {
            $template->render();
        }
        $this->content = ob_get_clean();

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return Template[]
     */
    public function getTemplates(): array
    {
        return $this->templates;
    }

}