<?php

namespace NiceModules\Tests\Core\Crud;

use NiceModules\Core\Crud;
use NiceModules\Core\Crud\CrudBuilder;
use NiceModules\CoreModule\Backend\Controller\ConfigurationController;
use NiceModules\CoreModule\Model\Configuration;
use PHPUnit\Framework\TestCase;

class CrudBuilderTest extends TestCase
{

    public function testBuild()
    {
        $controller = new ConfigurationController();
        $builder = new CrudBuilder($controller);
        $crud = $builder->build()->getCrud();
        
        $this->assertInstanceOf(Crud::class, $crud);
        $this->assertNotEmpty($crud->getHeaders());
        $this->assertNotEmpty($crud->getFields());
        $this->assertNotEmpty($crud->getOptions());
    }
    
}
