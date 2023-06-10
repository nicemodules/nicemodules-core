<?php

namespace NiceModules\Tests\Core\Crud;

use NiceModules\Core\Crud;
use NiceModules\Core\Crud\CrudBuilder;
use NiceModules\CoreModule\Backend\Controller\ConfigController;
use NiceModules\CoreModule\Model\Config;
use PHPUnit\Framework\TestCase;

class CrudBuilderTest extends TestCase
{

    public function testBuild()
    {
        $controller = new ConfigController();
        $builder = new CrudBuilder($controller);
        $crud = $builder->build()->getCrud();
        
        $this->assertInstanceOf(Crud::class, $crud);
        $this->assertNotEmpty($crud->getHeaders());
        $this->assertNotEmpty($crud->getFields());
        $this->assertNotEmpty($crud->getOptions());
    }
    
}
