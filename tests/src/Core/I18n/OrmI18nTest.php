<?php

namespace NiceModules\Core\I18n;

use PHPUnit\Framework\TestCase;

class OrmI18nTest extends TestCase
{

    public function testGetActiveLanguages()
    {
        $ormI18n = new OrmI18n('PL');
        
        $languages = $ormI18n->getActiveLanguages();
        
        self::assertNotEmpty($languages);
        
    }
}
