<?php

namespace NiceModules\Core\Controller;


use NiceModules\Core\Context;
use NiceModules\Core\Crud;
use NiceModules\Core\Helper\VuetifyHelper;
use NiceModules\Core\Lang;
use NiceModules\Core\Lang\Locales;
use NiceModules\Core\Model\Language;
use NiceModules\ORM\Manager;

class LanguageController extends CrudController
{
    protected string $modelClass = Language::class;
    
    public function getCrud(): Crud
    {
        $crud = parent::getCrud();
        $locales = new Locales();
        
        $crud->getField('shortcut')->options = VuetifyHelper::getSelectOptionsFromArray($locales->getLangs());
        
        return $crud;
    }
    
    public function edit()
    {

        $crud = $this->getCrud();
        $item = $this->getRequestParameter('subject');

        /** @var Language $language */
        $language = $this->getOrCreateObject($item);

        $locales = new Locales();
        
        $crudFields = $crud->getFields();

        $language->set('name', $locales->getLangName($item->shortcut));
        $language->set('shortcut', $item->shortcut);
        $language->set('active', $item->active);
        
        Manager::instance()->flush();

        $this->setResponse(self::SUCCESS,  Context::instance()->getLang()->get('The data has been saved correctly'));
        $this->renderJsonResponse();
    }
}