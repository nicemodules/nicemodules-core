<?php

namespace NiceModules\Tests\Core;

use NiceModules\Core\Installer;
use NiceModules\CoreModule\Model\Configuration;
use NiceModules\ORM\Manager;
use PHPUnit\Framework\TestCase;

class InstallerTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testInstallComposer()
    {
    }

    public function testInstallDatabase()
    {
        $installer = new Installer();
        $installer->addModel(Configuration::class);
        $installer->installDatabase();

        $result = Manager::instance()->getAdapter()->fetch('SHOW TABLES LIKE "' . Configuration::class . '"');
        $this->assertEmpty($result);
        
    }

    public function testAddModel()
    {
        $installer = new Installer();
        $installer->addModel(Configuration::class);
        $this->assertContains(Configuration::class, $installer->getModels());
    }
}
