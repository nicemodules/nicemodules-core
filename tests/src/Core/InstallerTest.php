<?php

namespace NiceModules\Tests\Core;

use NiceModules\Core\Installer;
use NiceModules\CoreModule\Model\Config;
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
        $installer->addModel(Config::class);
        $installer->installDatabase();

        $result = Manager::instance()->getAdapter()->fetch('SHOW TABLES LIKE "' . Config::class . '"');
        $this->assertEmpty($result);
        
    }

    public function testAddModel()
    {
        $installer = new Installer();
        $installer->addModel(Config::class);
        $this->assertContains(Config::class, $installer->getModels());
    }
}
