<?php

namespace TomasVotruba\Torch\Tests\Twig\Source;

use TomasVotruba\Torch\Contract\TwigEnvironmentDecoratorInterface;
use TomasVotruba\Torch\ValueObject\DummyTheme;
use Twig\Environment;
use Twig\TwigFunction;

final class SafeEnvironmentDecorator implements TwigEnvironmentDecoratorInterface
{
    public function decorate(Environment $environment): void
    {
        $environment->addFunction(new TwigFunction('dynamicTemplate', fn () => DummyTheme::LAYOUT_NAME));
    }
}
