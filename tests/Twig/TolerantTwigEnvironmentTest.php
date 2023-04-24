<?php

declare(strict_types=1);

namespace SmokedTwigRenderer\Tests\Twig;

use Ares\Tests\Helper\TestContainerFactory;
use Iterator;
use PHPUnit\Framework\TestCase;
use SmokedTwigRenderer\Twig\TolerantTwigEnvironment;
use SmokedTwigRenderer\Twig\TolerantTwigEnvironmentFactory;
use Twig\Error\RuntimeError;

final class TolerantTwigEnvironmentTest extends TestCase
{
    /**
     * @var TolerantTwigEnvironmentFactory
     */
    private $tolerantTwigEnvironmentFactory;

    protected function setUp(): void
    {
        $testContainerFactory = new TestContainerFactory();
        $container = $testContainerFactory->createWithConfigs([
            __DIR__ . '/../config/test_config.php',
        ]);

        $this->tolerantTwigEnvironmentFactory = $container->get(TolerantTwigEnvironmentFactory::class);
    }

    public function testCreate(): void
    {
        $this->assertInstanceOf(TolerantTwigEnvironmentFactory::class, $this->tolerantTwigEnvironmentFactory);

        $twig = $this->tolerantTwigEnvironmentFactory->create([]);
        $this->assertInstanceOf(TolerantTwigEnvironment::class, $twig);
    }

    public function testInvalid(): void
    {
        $templateFilePath = __DIR__ . '/Fixture/invalid/missing_constant.twig';

        $tolerantTwig = $this->tolerantTwigEnvironmentFactory->create([$templateFilePath]);

        $this->expectException(RuntimeError::class);
        $tolerantTwig->render($templateFilePath);
    }

    /**
     * @dataProvider provideData()
     */
    public function testRender(string $templateFilePath, string $expectedRenderedHtmlFilePath): void
    {
        $tolerantTwig = $this->tolerantTwigEnvironmentFactory->create([$templateFilePath]);

        $source = $tolerantTwig->getLoader()
            ->getSourceContext($templateFilePath);
        $this->assertStringEqualsFile($templateFilePath, $source->getCode());

        $templateContent = $tolerantTwig->render($templateFilePath);
        $this->assertStringEqualsFile($expectedRenderedHtmlFilePath, $templateContent);
    }

    public function provideData(): Iterator
    {
        yield [
            __DIR__ . '/Fixture/extends_dynamic_template.twig',
            __DIR__ . '/Fixture/expected/expected_simple.html',
        ];

        yield [
            __DIR__ . '/Fixture/with_form_theme.twig',
            __DIR__ . '/Fixture/expected/expected_form_theme.html',
        ];

        yield [
            __DIR__ . '/Fixture/existing_constant.twig',
            __DIR__ . '/Fixture/expected/expected_constant.html',
        ];
    }
}
