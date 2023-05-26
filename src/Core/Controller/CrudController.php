<?php

namespace NiceModules\Core\Controller;

use NiceModules\Core\Context;
use NiceModules\Core\Controller;
use NiceModules\Core\Crud;
use NiceModules\Core\Crud\CrudBuilder;
use NiceModules\Core\Template;
use NiceModules\Core\Template\TemplateRenderer;
use NiceModules\ORM\Manager;
use NiceModules\ORM\QueryBuilder;

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

    protected function render(){

        $this->templateRenderer = new TemplateRenderer('');

      

        foreach ($this->getTemplates() as $template){
            $this->templateRenderer->addTemplate($template);
        }

        $this->templateRenderer->render();
        $this->content = $this->templateRenderer->getContent();
    }
    
    protected function getCrud(): Crud
    {
        $builder = new CrudBuilder($this->modelClass, $this);
        return $builder->build()->getCrud();
    }
    
    protected function getTemplates(){
        $this->templates = [
            new Template('Backend/Crud/filters'),
            new Template(
                'Backend/Crud/app',
                [
                    'get_items_uri' => $this->getAjaxUri('getItems'),
                    'save_uri' => $this->getAjaxUri('save'),
                    'delete_uri' => $this->getAjaxUri('delete'),
                    'crud' => $this->getCrud()
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
        $options = json_decode(Context::instance()->getRequest()->get('options'));

        $queryBuilder = Manager::instance()->getRepository($this->class)->createQueryBuilder();

        $queryBuilder->limit($options->itemsPerPage, ($options->page - 1) * $options->itemsPerPage);

        $sort = $this->getSort($options);

        foreach ($sort as $order) {
            $queryBuilder->orderBy($order->column, $order->direction);
        }

        $queryBuilder->buildQuery();

        return json_encode($queryBuilder->getResultArray());
    }

    protected function getSort($options)
    {
        $sort = [];

        if (isset($options->sortBy)) {
            foreach ($options->sortBy as $k => $column) {
                $sort[$k] = ['column' => $column];
            }

            foreach ($options->sortDesc as $k => $value) {
                if ($value) {
                    $sort[$k] = ['direction' => QueryBuilder::ORDER_DESC];
                } else {
                    $sort[$k] = ['direction' => QueryBuilder::ORDER_ASC];
                }
            }
        }

        return $sort;
    }

    public function getAjaxUri($methodName)
    {
        return Context::instance()->getActivePlugin()->getRouter()->getUri(self::class, $methodName);
    }
}