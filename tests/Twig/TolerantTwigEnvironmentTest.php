<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Tests\Twig;

use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use TomasVotruba\Torch\Contract\TwigEnvironmentDecoratorInterface;
use TomasVotruba\Torch\Tests\AbstractTestCase;
use TomasVotruba\Torch\Tests\Twig\Source\SafeEnvironmentDecorator;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironment;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironmentFactory;
use Twig\Error\RuntimeError;
use Twig\Node\Node;

final class TolerantTwigEnvironmentTest extends AbstractTestCase
{
    private TolerantTwigEnvironmentFactory $tolerantTwigEnvironmentFactory;

    protected function setUp(): void
    {
        parent::setUp();

        // dynamic way to add a service, decorate with "dynamicTemplate()" function here
        $this->container->bind('twig_environment_decorator', static fn (): SafeEnvironmentDecorator => new SafeEnvironmentDecorator());

        $this->container->tag('twig_environment_decorator', TwigEnvironmentDecoratorInterface::class);

        $this->tolerantTwigEnvironmentFactory = $this->make(TolerantTwigEnvironmentFactory::class);
    }

    public function testCreate(): void
    {
        $this->assertInstanceOf(TolerantTwigEnvironmentFactory::class, $this->tolerantTwigEnvironmentFactory);

        $tolerantTwigEnvironment = $this->tolerantTwigEnvironmentFactory->create([]);
        $this->assertInstanceOf(TolerantTwigEnvironment::class, $tolerantTwigEnvironment);
    }

    public function testInvalid(): void
    {
        $templateFilePath = __DIR__ . '/Fixture/invalid/missing_constant.twig';
        $tolerantTwig = $this->tolerantTwigEnvironmentFactory->create([$templateFilePath]);

        $this->expectException(RuntimeError::class);
        $tolerantTwig->render($templateFilePath);
    }

    #[DataProvider('provideData')]
    public function testRender(string $templateFilePath, string $expectedRenderedHtmlFilePath): void
    {
        $tolerantTwigEnvironment = $this->tolerantTwigEnvironmentFactory->create([$templateFilePath]);

        $source = $tolerantTwigEnvironment->getLoader()
            ->getSourceContext($templateFilePath);

        $this->assertStringEqualsFile($templateFilePath, $source->getCode());

        $templateContent = $tolerantTwigEnvironment->render($templateFilePath);
        $this->assertStringEqualsFile($expectedRenderedHtmlFilePath, $templateContent);
    }

    public static function provideData(): Iterator
    {
        yield [
            __DIR__ . '/Fixture/extends_dynamic_template.twig',
            __DIR__ . '/Fixture/expected/expected_simple.html',
        ];

        // testing override of this this form part: vendor/symfony/twig-bridge/Node/FormThemeNode.php:29
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
