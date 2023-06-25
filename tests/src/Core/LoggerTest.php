<?php

namespace NiceModules\Testes\Core;

use NiceModules\Core\Logger;
use NiceModules\CoreModule\Model\Log;
use NiceModules\ORM\Manager;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    public function testAdd(){
        $logId = Logger::add('TEST3', 'phpunit');
        
        $entry = Manager::instance()
            ->getRepository(Log::class)
            ->find($logId);
        
        $this->assertEquals($entry->getId(), $logId);
    }
}
