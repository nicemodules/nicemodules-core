<?php
declare(strict_types=1);

namespace NiceModules\Tests\Core;

use Exception;
use NiceModules\Core\Template;
use PHPUnit\Framework\TestCase;

final class TemplateTest extends TestCase
{
    public function test__construct()
    {
        $params = [
            'param1' => PHP_EOL . 'TEST',
            'param2' => PHP_EOL . 'OK'
        ];

        $template = new Template(
            'tests/test',
            $params,
        );

        $this->assertContains($params['param1'], $template->getParams());
        $this->assertContains($params['param2'], $template->getParams());
        $this->assertNotEmpty($template->getTemplateDir());
        $this->assertFileExists($template->getFile());
    }

    public function testRender()
    {
        $params = [
            'param1' => 'TEST',
            'param2' => 'OK'
        ];

        $expectedOutput = implode('', $params);

        $template = new Template(
            'tests/test',
            $params
        );

        ob_start();
        $template->render();
        $actualOutput = ob_get_clean();

        $this->assertEquals($expectedOutput, $actualOutput);
    }

    public function testRenderException()
    {
        $template = new Template(
            'tests/undefined',
        );

        try {
            $template->render();
        } catch (Exception $e) {
            $this->assertInstanceOf(Exception::class, $e);
            $this->assertEquals('Template file does not exist ' . $template->getFile(), $e->getMessage());
            return;
        }

        $this->fail('Expected exception was not thrown');
    }

    /**
     * @covers NiceModules\Core\Template::setParams
     * @covers NiceModules\Core\Template::getParams
     */
    public function testGetParams()
    {
        $template = new Template(
            'tests/test'
        );

        $newParams = [
            'param1' => PHP_EOL . 'SECOND_TEST',
            'param2' => PHP_EOL . 'SECOND_OK'
        ];

        $template->setParams($newParams);

        $this->assertEquals($newParams, $template->getParams());
    }

    /**
     * @covers NiceModules\Core\Template::setFile
     * @covers NiceModules\Core\Template::getFile
     */
    public function testGetFile()
    {
        $template = new Template(
            ''
        );

        $newFile = 'tests/test';

        $template->setFile($newFile);

        $this->assertFileExists($template->getFile());
    }

    /**
     * @covers NiceModules\Core\Template::setTemplateDir
     * @covers NiceModules\Core\Template::getTemplateDir
     */
    public function testGetTemplateDir()
    {
        $template = new Template(
            'tests/test'
        );

        $newTemplateDir = 'TEST';

        $template->setTemplateDir($newTemplateDir);

        $this->assertEquals($newTemplateDir, $template->getTemplateDir());
    }

    public function testSetParam()
    {
        $template = new Template(
            'tests/test'
        );

        $template->setParam('test', 'test');

        $params = $template->getParams();

        $this->assertArrayHasKey('test', $params);
        $this->assertContains('test', $params);
    }

}
