<?php

namespace NiceModules\Core\Controller;

use NiceModules\Core\Annotation\CrudField;
use NiceModules\Core\Context;
use NiceModules\Core\Controller;
use NiceModules\Core\Crud;
use NiceModules\Core\Crud\CrudBuilder;
use NiceModules\Core\I18n\OrmI18n;
use NiceModules\Core\Repository\I18nModelRepository;
use NiceModules\Core\Session;
use NiceModules\Core\Template;
use NiceModules\Core\Template\TemplateRenderer;
use NiceModules\ORM\Exceptions\InvalidOperatorException;
use NiceModules\ORM\Exceptions\PropertyDoesNotExistException;
use NiceModules\ORM\Exceptions\RepositoryClassNotDefinedException;
use NiceModules\ORM\Exceptions\RequiredAnnotationMissingException;
use NiceModules\ORM\Exceptions\UnknownColumnTypeException;
use NiceModules\ORM\Manager;
use NiceModules\ORM\Mapper;
use NiceModules\ORM\QueryBuilder;
use ReflectionException;
use stdClass;
use Throwable;

/**
 * Base class for CRUD Controllers with for 18nModels
 * Set the $modelClass property in child class to create default CRUD for model
 */
abstract class I18nCrudController extends CrudController
{
    
    public function getOrmI18n(): OrmI18n
    {
        return Context::instance()->getOrmI18n();
    }
    
    public function getItems()
    {
        $options = $this->getRequestParameter('options');
        $filters = $this->getRequestParameter('filters');

        $queryBuilder = Manager::instance()->getRepository($this->modelClass)->createQueryBuilder();

        // if using not default language, join translation for current language
        if ($this->getOrmI18n()->needTranslation()) {
            $queryBuilder->leftJoin('ID', $this->getTableI18nModelName(), 'object_id');
            $where = $queryBuilder->getLeftJoinWhere('ID', $this->getTableI18nModelName());
            $where->addCondition($this->getTableI18nModelName(), 'language', $this->getOrmI18n()->getLanguage());
        }

        if ($filters) {
            $this->addFilters($filters, $queryBuilder);
        }

        $queryBuilder->limit($options->itemsPerPage, ($options->page - 1) * $options->itemsPerPage);
        $sort = $this->getSort($options);

        foreach ($sort as $order) {
            $queryBuilder->orderBy($order['column'], $order['direction']);
        }

        $queryBuilder->buildQuery();
        
        echo json_encode(
            [
                'items' => $queryBuilder->getResultArray(),
                'count' => $queryBuilder->getCount()
            ]
        );
        exit;
    }

    public function edit()
    {
        $crud = $this->getCrud();
        $item = $this->getRequestParameter('subject');

        $object = $this->getOrCreateObject($item);

        $crudFields = $crud->getFields();

        foreach ($item as $field => $value) {
            if (isset($crudFields[$field]) && $crudFields[$field]->editable) {
                $object->setTranslated($field, $value);
            }
        }

        Manager::instance()->flush();
        
        /** @var I18nModelRepository $repository */
        $repository = Manager::instance()->getRepository($this->modelClass);
        $repository->translateObject($object);

        $this->setResponse(
            self::SUCCESS,
            Context::instance()->getInterfaceI18n()->get('The data has been saved correctly')
        );

        $this->renderJsonResponse();
    }
    
    protected function getOrCreateObject(stdClass $item)
    {
        if ($item->ID) {
            $queryBuilder = Manager::instance()
                ->getRepository($this->modelClass)
                ->createQueryBuilder();
            
            if($this->getOrmI18n()->needTranslation()){
                $queryBuilder->leftJoin('ID', $this->getTableI18nModelName(), 'object_id');
                $where = $queryBuilder->getLeftJoinWhere('ID', $this->getTableI18nModelName());
                $where->addCondition($this->getTableI18nModelName(), 'language', $this->getOrmI18n()->getLanguage());    
            }
            
            $queryBuilder->where('ID', $item->ID);

            return $queryBuilder->buildQuery()->getSingleResult();
        } else {
            $object = new $this->modelClass();
            Manager::instance()->persist($object);
            return $object;
        }
    }

    /**
     * @param stdClass $filters
     * @param QueryBuilder $queryBuilder
     * @throws InvalidOperatorException
     * @throws PropertyDoesNotExistException
     * @throws Throwable
     */
    protected function addFilters(stdClass $filters, QueryBuilder $queryBuilder)
    {
        foreach ($filters as $filter) {
            if ($filter->value) {
                switch ($filter->type) {
                    case CrudField::TYPE_DATE:
                    case CrudField::TYPE_DATE_TIME:
                        {
                            $timeFrom = '00:00:00';
                            $timeTo = '23:59:59';

                            if (count($filter->value) == 2) {
                                $queryBuilder->where($filter->name, $filter->value[0] . ' ' . $timeFrom, '>=');
                                $queryBuilder->where($filter->name, $filter->value[1] . ' ' . $timeTo, '<=');
                            } else {
                                $queryBuilder->where($filter->name, $filter->value[0] . ' ' . $timeFrom, '>=');
                                $queryBuilder->where($filter->name, $filter->value[0] . ' ' . $timeTo, '<=');
                            }
                        }
                        break;
                    case CrudField::TYPE_TEXT:
                        {
                            $words = explode(' ', $filter->value);

                            $value = '%' . implode('%', $words) . '%';


                            // if using not default language, search in translated fields
                            if ($this->needPropertyTranslation($filter->name)) {
                              
                                $where = $queryBuilder->getWhere();
                                $where->addCondition($this->getTableI18nModelName(), $filter->name, $value, 'LIKE');
                            } else {
                                $queryBuilder->where($filter->name, $value, 'LIKE');
                            }
                        }
                        break;
                    default:
                        {
                            // if using not default language, search in translated fields
                            if ($this->needPropertyTranslation($filter->name)) {
                                $where = $queryBuilder->getWhere();
                                $where->addCondition($this->getTableI18nModelName(), $filter->name, $filter->value);
                            } else {
                                $queryBuilder->where($filter->name, $filter->value);
                            }
                        }
                        break;
                }
            }
        }
    }
    
    public function selectLanguage(){
        $language =  $this->getRequestParameter('subject');
        
        Session::instance()->set('orm_language', $language->shortcut);
        
        $this->setResponse(
            self::SUCCESS,
            Context::instance()->getInterfaceI18n()->get('The language has been changed to '.$language->name)
        );

        $this->renderJsonResponse();
    }
    
    protected function getTableI18nModelName(): ?string
    {
        $table = $this->getMapper()->getTable();
        return $table->custom['i18nModel'] ?? null;
    }

    protected function needPropertyTranslation($property): ?string
    {
        return $this->getMapper()->getPropertyCustom($property, 'i18n') && $this->getOrmI18n()->needTranslation();
    }
    
}