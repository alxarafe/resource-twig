<?php

declare(strict_types=1);

namespace Alxarafe\ResourceTwig\Tests\Unit;

use Alxarafe\ResourceTwig\TwigRenderer;
use Alxarafe\ResourceController\Contracts\RendererContract;
use PHPUnit\Framework\TestCase;

class TwigRendererTest extends TestCase
{
    private string $templatePath;
    private string $cachePath;

    protected function setUp(): void
    {
        $this->templatePath = sys_get_temp_dir() . '/twig_test_templates_' . uniqid();
        $this->cachePath = sys_get_temp_dir() . '/twig_test_cache_' . uniqid();
        mkdir($this->templatePath, 0755, true);
    }

    protected function tearDown(): void
    {
        $this->removeDir($this->templatePath);
        $this->removeDir($this->cachePath);
    }

    private function removeDir(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($items as $item) {
            $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
        }
        rmdir($dir);
    }

    public function testImplementsRendererContract(): void
    {
        $renderer = new TwigRenderer($this->templatePath);
        $this->assertInstanceOf(RendererContract::class, $renderer);
    }

    public function testRenderSimpleTemplate(): void
    {
        file_put_contents($this->templatePath . '/hello.html.twig', 'Hello, {{ name }}!');

        $renderer = new TwigRenderer($this->templatePath);
        $result = $renderer->render('hello', ['name' => 'World']);

        $this->assertSame('Hello, World!', $result);
    }

    public function testRenderWithLoop(): void
    {
        file_put_contents(
            $this->templatePath . '/list.html.twig',
            '{% for item in items %}{{ item }},{% endfor %}'
        );

        $renderer = new TwigRenderer($this->templatePath);
        $result = $renderer->render('list', ['items' => ['a', 'b', 'c']]);

        $this->assertSame('a,b,c,', $result);
    }

    public function testAutoAppendsExtension(): void
    {
        file_put_contents($this->templatePath . '/test.html.twig', 'OK');

        $renderer = new TwigRenderer($this->templatePath);
        $result = $renderer->render('test');

        $this->assertSame('OK', $result);
    }

    public function testExplicitExtensionNotDuplicated(): void
    {
        file_put_contents($this->templatePath . '/explicit.html.twig', 'Explicit');

        $renderer = new TwigRenderer($this->templatePath);
        $result = $renderer->render('explicit.html.twig');

        $this->assertSame('Explicit', $result);
    }

    public function testAddTemplatePath(): void
    {
        $extraPath = sys_get_temp_dir() . '/twig_extra_' . uniqid();
        mkdir($extraPath, 0755, true);
        file_put_contents($extraPath . '/extra.html.twig', 'Extra template');

        $renderer = new TwigRenderer($this->templatePath);
        $renderer->addTemplatePath($extraPath);
        $result = $renderer->render('extra');

        $this->assertSame('Extra template', $result);
        $this->removeDir($extraPath);
    }

    public function testMultipleInitialPaths(): void
    {
        $secondPath = sys_get_temp_dir() . '/twig_second_' . uniqid();
        mkdir($secondPath, 0755, true);
        file_put_contents($this->templatePath . '/first.html.twig', 'First');
        file_put_contents($secondPath . '/second.html.twig', 'Second');

        $renderer = new TwigRenderer([$this->templatePath, $secondPath]);

        $this->assertSame('First', $renderer->render('first'));
        $this->assertSame('Second', $renderer->render('second'));

        $this->removeDir($secondPath);
    }

    public function testGetEnvironment(): void
    {
        $renderer = new TwigRenderer($this->templatePath);
        $this->assertInstanceOf(\Twig\Environment::class, $renderer->getEnvironment());
    }

    public function testWithCachePath(): void
    {
        file_put_contents($this->templatePath . '/cached.html.twig', 'Cached');

        $renderer = new TwigRenderer($this->templatePath, $this->cachePath);
        $result = $renderer->render('cached');

        $this->assertSame('Cached', $result);
        $this->assertDirectoryExists($this->cachePath);
    }

    public function testDebugMode(): void
    {
        $renderer = new TwigRenderer($this->templatePath, false, true);
        $this->assertTrue($renderer->getEnvironment()->isDebug());
    }
}
