<?php

namespace NiceModules\Tests;

use NiceModules\Core\Installer;
use NiceModules\Model\Config;
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
    }

    public function testAddModel()
    {
        $installer = new Installer();
        $installer->addModel(Config::class);
        $this->assertContains(Config::class, $installer->getModels());
    }
}
