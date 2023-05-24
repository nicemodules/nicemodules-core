<?php

namespace NiceModules\Tests\Core\Crud;

use NiceModules\Core\Crud;
use NiceModules\Core\Crud\CrudBuilder;
use NiceModules\CoreModule\Model\Config;
use PHPUnit\Framework\TestCase;

class CrudBuilderTest extends TestCase
{

    public function testBuild()
    {
        $builder = new CrudBuilder(Config::class);
        $crud = $builder->build()->getCrud();
        
        $this->assertInstanceOf(Crud::class, $crud);
        $this->assertNotEmpty($crud->getHeaders());
        $this->assertNotEmpty($crud->getFields());
        $this->assertNotEmpty($crud->getCrudList());
    }
    
}
