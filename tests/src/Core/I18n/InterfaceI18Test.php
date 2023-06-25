<?php

namespace NiceModules\Tests\Core\i18n;


use NiceModules\Core\I18n\InterfaceI18n;
use NiceModules\CoreModule\CoreModule;
use PHPUnit\Framework\TestCase;


class InterfaceI18Test extends TestCase
{

    public function testGet()
    {
        $lang = new InterfaceI18n('PL');
        $lang->setDir(CoreModule::instance()->getLangDir());
        $this->assertEquals('Konfiguracja', $lang->get('Configuration'));
    }


}
