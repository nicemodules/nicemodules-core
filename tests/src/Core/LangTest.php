<?php

namespace NiceModules\Tests\Core;

use NiceModules\Core\Context;
use NiceModules\Core\Lang;
use NiceModules\Core\Lang\Locales;
use NiceModules\CoreModule\Backend\CoreBackendPlugin;
use NiceModules\CoreModule\CoreModule;
use PHPUnit\Framework\TestCase;


class LangTest extends TestCase
{

    public function testGet()
    {
        $locales = new Locales();
        $locales->matchLocales();
        die();
        $lang = new Lang('pl_PL');
        $lang->setDir(CoreModule::instance()->getLangDir());
        $this->assertEquals('Konfiguracja', $lang->get('Configuration'));
    }


}
