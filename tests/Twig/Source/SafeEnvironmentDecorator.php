<?php

namespace TomasVotruba\Torch\Tests\Twig\Source;

use TomasVotruba\Torch\Contract\TwigEnvironmentDecoratorInterface;
use TomasVotruba\Torch\ValueObject\DummyTheme;
use Twig\Environment;
use Twig\TwigFunction;

final class SafeEnvironmentDecorator implements TwigEnvironmentDecoratorInterface
{
    public function decorate(Environment $twigEnvironment): void
    {
        $twigEnvironment->addFunction(new TwigFunction('dynamicTemplate', static fn (): string => DummyTheme::LAYOUT_NAME));
    }
}
