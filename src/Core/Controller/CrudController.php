<?php

namespace NiceModules\Core\Controller;

use NiceModules\Core\Annotation\CrudField;
use NiceModules\Core\Context;
use NiceModules\Core\Controller;
use NiceModules\Core\Crud;
use NiceModules\Core\Crud\CrudBuilder;
use NiceModules\Core\I18n\OrmI18n;
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

/**
 * Base class for CRUD Controllers
 * Set the $modelClass property in child class to create default CRUD for model
 */
abstract class CrudController extends Controller
{
    protected string $modelClass;
    protected TemplateRenderer $templateRenderer;

    protected string $content;
    /**
     * @var Template[]
     */
    protected array $templates;

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return $this->modelClass;
    }

    public function getMapper(): Mapper
    {
        return Mapper::instance($this->modelClass);
    }

    public function getOrmI18n(): OrmI18n
    {
        return Context::instance()->getOrmI18n();
    }

    protected function render()
    {
        $this->templateRenderer = new TemplateRenderer('');

        foreach ($this->getTemplates() as $template) {
            $this->templateRenderer->addTemplate($template);
        }

        $this->templateRenderer->render();
        $this->content = $this->templateRenderer->getContent();
    }

    protected function getCrud(): Crud
    {
        $builder = new CrudBuilder($this);
        return $builder->build()->getCrud();
    }

    protected function getTemplates()
    {
        $crud = $this->getCrud();

        $crud->addUri('getItems', $this->getAjaxUri('getItems'));

        $this->templates = [
            new Template('Crud/edit'),
            new Template('Crud/filters'),
            new Template('Crud/item_actions'),
            new Template('Crud/top_button_actions'),
            new Template('Crud/bulk_actions'),
            new Template(
                'Crud/app',
                [
                    'crud' => $crud
                ]
            )
        ];

        return $this->templates;
    }

    public function list()
    {
        $this->render();

        return $this->content;
    }

    public function getItems()
    {
        $options = $this->getRequestParameter('options');
        $filters = $this->getRequestParameter('filters');

        $queryBuilder = Manager::instance()->getRepository($this->modelClass)->createQueryBuilder();

        if ($this->needTableTranslation()) {
            $queryBuilder->leftJoin('ID', $this->getTableI18nModelName(), 'object_id');
            $where = $queryBuilder->getLeftJoinWhere('ID', $this->getTableI18nModelName());
            $where->addCondition($this->getTableI18nModelName(),'language', $this->getOrmI18n()->getLanguage());
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
                if ($this->needTableTranslation()) {
                    $object->setTranslated($field, $value);
                } else {
                    $object->set($field, $value);
                }
            }
        }

        Manager::instance()->flush();

        $this->setResponse(
            self::SUCCESS,
            Context::instance()->getInterfaceI18n()->get('The data has been saved correctly')
        );
        $this->renderJsonResponse();
    }

    public function delete()
    {
        $item = $this->getRequestParameter('subject');

        $object = $this->getOrCreateObject($item);

        if ($object && $object->getId()) {
            Manager::instance()->remove($object);
            Manager::instance()->flush();

            $this->setResponse(self::SUCCESS, $this->interfaceI18n->get('The data has been deleted correctly'));
            $this->renderJsonResponse();
        } else {
            $this->setResponse(self::ERROR, $this->interfaceI18n->get('The data has been deleted correctly'));
            $this->renderJsonResponse();
        }
    }

    public function bulkDelete()
    {
        $items = $this->getRequestParameter('subject');

        $objects = $this->getSelectedItems($items);

        foreach ($objects as $object) {
            Manager::instance()->remove($object);
        }

        Manager::instance()->flush();

        $this->setResponse(self::SUCCESS, $this->interfaceI18n->get('The data has been deleted correctly'));
        $this->renderJsonResponse();
    }

    /**
     * @param stdClass[] $items
     * @return array
     * @throws RepositoryClassNotDefinedException
     * @throws RequiredAnnotationMissingException
     * @throws UnknownColumnTypeException
     * @throws ReflectionException
     */
    public function getSelectedItems(array $items)
    {
        $ids = [];

        foreach ($items as $item) {
            $ids[] = $item->ID;
        }

        $objects = Manager::instance()->getRepository($this->modelClass)->findIds($ids);

        return $objects;
    }

    protected function getOrCreateObject(stdClass $item)
    {
        if ($item->ID) {
            $queryBuilder = Manager::instance()->getRepository($this->modelClass)
                ->createQueryBuilder();
            
            if ($this->needTableTranslation()) {
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

    protected function getSort($options)
    {
        $sort = [];

        if (isset($options->sortBy)) {
            foreach ($options->sortBy as $k => $column) {
                $sort[$k]['column'] = $column;
            }

            foreach ($options->sortDesc as $k => $value) {
                if ($value) {
                    $sort[$k]['direction'] = QueryBuilder::ORDER_DESC;
                } else {
                    $sort[$k]['direction'] = QueryBuilder::ORDER_ASC;
                }
            }
        }

        return $sort;
    }

    public function getAjaxUri($methodName)
    {
        $page = Context::instance()->getActivePlugin()->getRouter()->getUri(get_called_class(), $methodName);
        return '?page=' . $page;
    }

    protected function needTableTranslation()
    {
        $table = $this->getMapper()->getTable();
        return isset($table->custom) && $table->custom['i18n'] && $this->getOrmI18n()->needTranslation();
    }

    protected function getTableI18nModelName(): ?string
    {
        $table = $this->getMapper()->getTable();
        return $table->custom['i18nModel'] ?? null;
    }

    protected function needPropertyTranslation($property): ?string
    {
        $column = $this->getMapper()->getColumn($property);
        return isset($column['i18n']) && $column['i18n'] && $this->getOrmI18n()->needTranslation();
    }
}