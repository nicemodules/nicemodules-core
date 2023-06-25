<?php

namespace NiceModules\Tests\Core\Template;

use NiceModules\Core\Template;
use NiceModules\Core\Template\TemplateRenderer;
use PHPUnit\Framework\TestCase;

class TemplateRendererTest extends TestCase
{
    

    public function testGetContent()
    {
        $renderer = new TemplateRenderer('Test title');

        $template1 = $this->createMock(Template::class);
        $template1->expects($this->once())
            ->method('render')
            ->willReturnCallback(function () {
                echo "TESTOK";
            });

        $template2 = $this->createMock(Template::class);
        $template2->expects($this->once())
            ->method('render')
            ->willReturnCallback(function () {
                echo "TESTOK";
            });
        
        $renderer->addTemplate($template1)
            ->addTemplate($template2)
            ->render();

        $this->assertEquals('TESTOKTESTOK', $renderer->getContent());
    }

    public function testAddTemplate()
    {
        $renderer = new TemplateRenderer('Test title');
        $template = $this->createMock(Template::class);
        $renderer->addTemplate($template);
        $this->assertContains($template, $renderer->getTemplates());
    }
}
