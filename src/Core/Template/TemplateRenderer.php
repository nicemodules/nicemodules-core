<?php

namespace NiceModules\Core\Template;

use NiceModules\Core\Template;

class TemplateRenderer
{
    protected string $title;
    protected string $content;
    /**
     * @var Template[] 
     */
    protected array $templates;

    /**
     * @param $title
     */
    public function __construct($title)
    {
        $this->title = $title;
    }
    
    public function addTemplate(Template $template): TemplateRenderer
    {
        $template->setParam('_renderer', $this);
        
        $this->templates[] = $template;
        
        return $this;
    }
    
    public function render(): TemplateRenderer
    {
        ob_start();
        foreach ($this->templates as $template){
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return Template[]
     */
    public function getTemplates(): array
    {
        return $this->templates;
    }

}