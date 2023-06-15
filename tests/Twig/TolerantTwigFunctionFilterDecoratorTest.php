<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Tests\Twig;

use TomasVotruba\Torch\Tests\AbstractTestCase;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironment;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironmentFactory;
use Twig\TwigFunction;

final class TolerantTwigFunctionFilterDecoratorTest extends AbstractTestCase
{
    private TolerantTwigEnvironment $tolerantTwigEnvironment;

    protected function setUp(): void
    {
        parent::setUp();

        $tolerantTwigEnvironmentFactory = $this->make(TolerantTwigEnvironmentFactory::class);
        $this->tolerantTwigEnvironment = $tolerantTwigEnvironmentFactory->create([]);
    }

    public function testFormStart(): void
    {
        $twigFunction = $this->tolerantTwigEnvironment->getFunction('form_start');
        $this->assertInstanceOf(TwigFunction::class, $twigFunction);

        $this->assertIsCallable($twigFunction->getCallable());
    }

    public function testFormWidget(): void
    {
        $twigFunction = $this->tolerantTwigEnvironment->getFunction('form_widget');

        $callable = $twigFunction->getCallable();
        $this->assertIsCallable($callable);

        $result = ($callable)(null);
        $this->assertSame('', $result);
    }
}
