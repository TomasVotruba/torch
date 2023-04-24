<?php

declare(strict_types=1);

namespace SmokedTwigRenderer\Tests\Twig;

use Ares\Tests\Helper\TestContainerFactory;
use PHPUnit\Framework\TestCase;
use SmokedTwigRenderer\Twig\TolerantTwigEnvironment;
use SmokedTwigRenderer\Twig\TolerantTwigEnvironmentFactory;
use Twig\TwigFunction;

final class TolerantTwigFunctionFilterDecoratorTest extends TestCase
{
    private TolerantTwigEnvironment $tolerantTwigEnvironment;

    protected function setUp(): void
    {
        $testContainerFactory = new TestContainerFactory();
        $container = $testContainerFactory->create();

        $tolerantTwigFactory = $container->get(TolerantTwigEnvironmentFactory::class);
        $this->tolerantTwigEnvironment = $tolerantTwigFactory->create([]);
    }

    public function testFormStart(): void
    {
        $formStartFunction = $this->tolerantTwigEnvironment->getFunction('form_start');
        $this->assertInstanceOf(TwigFunction::class, $formStartFunction);

        $this->assertIsCallable($formStartFunction->getCallable());
    }

    public function testFormWidget(): void
    {
        $formWidget = $this->tolerantTwigEnvironment->getFunction('form_widget');

        $result = ($formWidget->getCallable())(null);
        $this->assertSame('', $result);
    }
}
