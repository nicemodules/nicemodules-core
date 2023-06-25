<?php

namespace NiceModules\Core\Model;

use NiceModules\Core\Context;
use NiceModules\Core\I18n\OrmI18n;
use NiceModules\Core\Model;
use NiceModules\ORM\Annotations\Table;
use NiceModules\ORM\Exceptions\InvalidOperatorException;
use NiceModules\ORM\Exceptions\PropertyDoesNotExistException;
use NiceModules\ORM\Exceptions\RepositoryClassNotDefinedException;
use NiceModules\ORM\Exceptions\RequiredAnnotationMissingException;
use NiceModules\ORM\Exceptions\UnknownColumnTypeException;
use NiceModules\ORM\Manager;
use NiceModules\ORM\Models\BaseModel;
use ReflectionException;

/**
 * @Table(
 *     inherits="NiceModules\Core\Model"
 *     )
 */
class i18nModel extends Model
{
    protected function getOrmI18n(){
        return Context::instance()->getOrmI18n();
    }
    
    /**
     * @param $property
     * @param $value
     * @return void
     * @throws InvalidOperatorException
     * @throws PropertyDoesNotExistException
     * @throws ReflectionException
     * @throws RepositoryClassNotDefinedException
     * @throws RequiredAnnotationMissingException
     * @throws UnknownColumnTypeException
     */
    public function setTranslated($property, $value): void
    {
        if($this->isI18n($property) && $this->getOrmI18n()->needTranslation()){
            $this->getI18n()->set($property, $value);
            return;
        }
        
        $this->set($property, $value);
    }

    /**
     * @param string $property
     * @return mixed|null
     * @throws InvalidOperatorException
     * @throws PropertyDoesNotExistException
     * @throws ReflectionException
     * @throws RepositoryClassNotDefinedException
     * @throws RequiredAnnotationMissingException
     * @throws UnknownColumnTypeException
     */
    public function getTranslated(string $property)
    {
        if ($this->isI18n($property) && $this->getOrmI18n()->needTranslation()) {
            return $this->getI18n()->get($property);
        }

        return $this->get($property);
    }

    /**
     * @return array
     * @throws InvalidOperatorException
     * @throws PropertyDoesNotExistException
     * @throws ReflectionException
     * @throws RepositoryClassNotDefinedException
     * @throws RequiredAnnotationMissingException
     * @throws UnknownColumnTypeException
     */
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

    /**
     * @return BaseModel
     * @throws PropertyDoesNotExistException
     * @throws InvalidOperatorException
     * @throws RepositoryClassNotDefinedException
     * @throws RequiredAnnotationMissingException
     * @throws UnknownColumnTypeException
     * @throws ReflectionException
     */
    public function getI18n(): BaseModel
    {
        $i18nClass = $this->getI18nClassName();
        $i18n = $this->getObjectRelatedBy('ID', $i18nClass);

        if (!$i18n) {
            $i18n = new $i18nClass();

            $this->setObjectRelatedBy('ID', $i18n);

            if ($this->getId()) {
                $i18n->set('object_id', $this->getId());
                Manager::instance()->persist($i18n);
            }

            $i18n->set('language', $this->getOrmI18n()->getLanguage());
        }

        return $i18n;
    }

    /**
     * @throws InvalidOperatorException
     * @throws PropertyDoesNotExistException
     * @throws ReflectionException
     * @throws RepositoryClassNotDefinedException
     * @throws RequiredAnnotationMissingException
     * @throws UnknownColumnTypeException
     */
    public function afterSave()
    {
        parent::afterSave();

        if ($this->getOrmI18n()->needTranslation()) {
            if (!$this->getI18n()->getId()) {
                $this->getI18n()->set('object_id', $this->getId());
                Manager::instance()->persist($this->getI18n());
            }
        }

        Manager::instance()->getRepository($this->getClassName())->translateObject($this);
    }

    /**
     * @param $property
     * @return bool
     */
    public function needTranslation($property): bool
    {
        return $this->isI18n($property) && $this->getMapper()->isTextProperty($property);
    }

    public function isI18n($property)
    {
        $column = $this->getMapper()->getColumn($property);
        return isset($column->custom['i18n']) && $column->custom['i18n'];
    }

    /**
     * @return string
     */
    public function getI18nClassName(): string
    {
        return $this->getClassName() . 'I18n';
    }

    /**
     * @return array
     */
    public function getI18nProperties(): array
    {
        $i18nColumns = [];
        foreach ($this->getColumnNames() as $columnName) {
            if ($this->isI18n($columnName)) {
                $i18nColumns[] = $columnName;
            }
        }
        return $i18nColumns;
    }
}