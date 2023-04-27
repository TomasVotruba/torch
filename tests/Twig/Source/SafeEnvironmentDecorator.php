<?php

namespace TomasVotruba\Torch\Tests\Twig\Source;

use TomasVotruba\Torch\Contract\EnvironmentDecoratorInterface;
use TomasVotruba\Torch\ValueObject\DummyTheme;
use Twig\Environment;
use Twig\TwigFunction;

final class SafeEnvironmentDecorator implements EnvironmentDecoratorInterface
{
    public function decorate(Environment $environment): void
    {
        $environment->addFunction(new TwigFunction('dynamicTemplate', fn () => DummyTheme::LAYOUT_NAME));
    }
}
