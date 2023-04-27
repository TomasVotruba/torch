<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Tests\Twig;

use TomasVotruba\Torch\Tests\AbstractTestCase;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironment;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironmentFactory;
use Twig\TwigFunction;
use Webmozart\Assert\Assert;

final class TolerantTwigFunctionFilterDecoratorTest extends AbstractTestCase
{
    private TolerantTwigEnvironment $tolerantTwigEnvironment;

    protected function setUp(): void
    {
        parent::setUp();

        $tolerantTwigFactory = $this->make(TolerantTwigEnvironmentFactory::class);
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

        $callable = $formWidget->getCallable();
        Assert::isCallable($callable);

        $result = ($callable)(null);
        $this->assertSame('', $result);
    }
}
