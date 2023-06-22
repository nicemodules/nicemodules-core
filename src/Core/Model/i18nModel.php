<?php

namespace NiceModules\Core\Model;

use NiceModules\Core\Context;
use NiceModules\Core\Model;
use NiceModules\ORM\Annotations\Column;
use NiceModules\ORM\Annotations\Table;
use NiceModules\ORM\Manager;
use NiceModules\ORM\Models\BaseModel;

/**
 * @Table(
 *     inherits="NiceModules\Core\Model"
 *      custom={i18n=true}
 *     )
 *
 */
class i18nModel extends Model
{
    protected BaseModel $i18n;

   
    
    public function getTranslated($property){
        return $this->getI18n()->get($property);
    }
    
    public function getAllValues(): array
    {
        $values = [];
        foreach (array_keys($this->getColumns()) as $property) {
            $values[$property] = $this->getTranslated($property);
        }

        foreach ($this->relatedObjects as $property => $models) {
            foreach ($models as $modelName => $object) {
                $values['relatedObjects'][$property][$modelName] = $object->getAllValues();
            }
        }
        
        return $values;
    }
    
    public function getI18n(): BaseModel
    {
        $i18nClass = $this->getClassName().'I18n';
        
        $i18n = $this->getObjectRelatedBy('ID', $i18nClass);

       
        
        if(!$i18n){
            $i18n = new $i18nClass();
            
            $this->setObjectRelatedBy('ID', $i18nClass);
            
            if ($this->getId()) {
                $this->i18n->set('object_id', $this->getId());
                Manager::instance()->persist($this->i18n);
            }

            $this->i18n->set('language', Context::instance()->getOrmI18n()->getLanguage());
        }
        
        return $i18n;
    }
}