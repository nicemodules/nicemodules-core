<?php

namespace NiceModules\Core\Repository;


use NiceModules\Core\Context;
use NiceModules\Core\I18n\OrmI18n;
use NiceModules\Core\Model\i18nModel;
use NiceModules\Core\Repository;
use NiceModules\ORM\Manager;
use NiceModules\ORM\Models\BaseModel;

class I18nModelRepository extends Repository
{
    protected OrmI18n $i18n;

    public function translateObject(i18nModel $object)
    {
        $this->i18n = Context::instance()->getOrmI18n();

        if (!$this->i18n->hasServiceEnabled()) {
            return;
        }

        // Get object i18ns
        $objectI18ns = Manager::instance()
            ->getRepository($object->getI18nClassName())
            ->createQueryBuilder()
            ->where('object_id', $object->getId())
            ->where('language', $this->i18n->getActiveLanguagesArray(), 'IN')
            ->where('language', $this->i18n->getLanguage(), '!=')
            ->buildQuery()
            ->getResult();

        $objectI18nsByLanguage = [];

        foreach ($objectI18ns as $objectI18n) {
            $objectI18nsByLanguage[$objectI18n->get('language')] = $objectI18n;
        }

        //Create new i18ns if needed
        foreach ($this->i18n->getActiveLanguagesArray() as $language) {
            if ($language !== OrmI18n::DEFAULT_LANGUAGE
                && !isset($objectI18nsByLanguage[$language])
                && $language !== $this->i18n->getLanguage()) {
                $i18nClassName = $object->getI18nClassName();
                $objectI18nsByLanguage[$language] = new $i18nClassName();
                $objectI18nsByLanguage[$language]->set('object_id', $object->getId());
                $objectI18nsByLanguage[$language]->set('language', $language);
                Manager::instance()->persist($objectI18nsByLanguage[$language]);
            }
        }

        if (!$this->i18n->needTranslation()) {
            //translate only object i18ns - default values are already set
            foreach ($objectI18nsByLanguage as $language => $i18nObject) {
                foreach ($object->getI18nProperties() as $property) {
                    // translation needed only for text type properties

                    if (!$object->needTranslation($property)) {
                        continue;
                    }

                    //proceed translation from default language to i18n language
                    $this->translateProperty(
                        $i18nObject,
                        $property,
                        $object->get($property),
                        OrmI18n::DEFAULT_LANGUAGE,
                        $language
                    );
                }
            }
        } else {
            //translate default object values
            foreach ($object->getI18nProperties() as $property) {
                if (!$object->needTranslation($property)) {
                    continue;
                }

                //proceed translation from current language
                $this->translateProperty(
                    $object,
                    $property,
                    $object->getI18n()->get($property),
                    $this->i18n->getLanguage(),
                    OrmI18n::DEFAULT_LANGUAGE
                );
            }

            //translate objectI18ns
            foreach ($objectI18nsByLanguage as $language => $i18nObject) {
                foreach ($object->getI18nProperties() as $property) {
                    // translation needed only for text type properties
                    if (!$object->needTranslation($property)) {
                        continue;
                    }

                    //proceed translation from current object language
                    $this->translateProperty(
                        $i18nObject,
                        $property,
                        $object->getI18n()->get($property),
                        $object->getI18n()->get('language'),
                        $language
                    );
                }
            }
        }

        Manager::instance()->flush();
    }
    
    protected function translateProperty(
        BaseModel $object,
        string $property,
        ?string $text,
        string $sourceLanguage,
        string $targetLanguage
    ) {
        if ($text === '' || $text === null) {
            return;
        }

        // not empty properties are already translanted 
        if ($object->get($property) !== '' && $object->get($property) !== null) {
            return;
        }

        $object->set($property, $this->i18n->translate($text, $sourceLanguage, $targetLanguage));
    }
}