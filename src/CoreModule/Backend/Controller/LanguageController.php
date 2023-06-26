<?php

namespace NiceModules\CoreModule\Backend\Controller;


use NiceModules\Core\Context;
use NiceModules\Core\Controller\CrudController;
use NiceModules\Core\Crud;
use NiceModules\Core\Helper\VuetifyHelper;
use NiceModules\Core\Lang\Locales;
use NiceModules\CoreModule\Model\Language;
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
        $interfaceI18n = Context::instance()->getInterfaceI18n();
        
        $item = $this->getRequestParameter('subject');

        /** @var Language $language */
        $language = $this->getOrCreateObject($item);

        $locales = new Locales();

        $language->set('name', $locales->getLangName($item->shortcut));
        $language->set('shortcut', $item->shortcut);
        $language->set('active', $item->active);
        $language->set('flag', $interfaceI18n->getFlag($language->get('shortcut')));

        Manager::instance()->flush();

        $this->setResponse(
            self::SUCCESS,
            $interfaceI18n->get('The data has been saved correctly')
        );
        $this->renderJsonResponse();
    }
}