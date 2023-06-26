<?php

namespace NiceModules\Core\Template;

use DirectoryIterator;
use NiceModules\Core\Template;
use NiceModules\CoreModule\CoreModule;
use Symfony\Component\Finder\SplFileInfo;

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
    
    public function getTemplatesFromDir($dir, array &$templates = [],  array $exclude = []){
        $directoryIterator = new DirectoryIterator($dir);

        foreach ($directoryIterator as $file) {
            /** @var SplFileInfo $file */
            if ($file->isFile()) {
                $fileName = $file->getBasename('.' . $file->getExtension());
                if(!in_array($fileName, $exclude)){
                    $template = new Template($fileName);
                    $template->setTemplateDir($dir);
                    $templates[] = $template;    
                }
            }
        }
        
        return $templates;
    }

}