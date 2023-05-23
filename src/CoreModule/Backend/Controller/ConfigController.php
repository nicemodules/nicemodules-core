<?php

namespace NiceModules\CoreModule\Backend\Controller;

use NiceModules\Core\Controller;
use NiceModules\Core\Template;
use NiceModules\Core\Template\TemplateRenderer;
use NiceModules\CoreModule\CoreModule;
use NiceModules\CoreModule\Model\Config;

class ConfigController extends Controller
{
    public function list()
    {
        $templateRenderer = new TemplateRenderer('Configuration');
        
        $builder = new CrudBuilder(Config::class);
        $builder->build();
        $crud = $builder->getCrud();

        $templateRenderer
            ->addTemplate(new Template('Backend/CRUD/filters'))
            ->addTemplate(new Template('Backend/CRUD/app', ['crud' => $crud]));

        $output = '';
        $outputs['Plugin dir'] = CoreModule::instance()->getPluginDir();
        $outputs['Plugin url'] = CoreModule::instance()->getPluginUrl();
        $outputs['Plugin file'] = CoreModule::instance()->getPluginFile();

        foreach ($outputs as $name => $out) {
            $output .= '<br>' . $name . ': ' . $out;
        };

        return $templateRenderer->render()->getContent();
    }
}