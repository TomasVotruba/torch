<?php

namespace SmokedTwigRenderer\Tests\Twig\Source;

use SmokedTwigRenderer\Contract\EnvironmentDecoratorInterface;
use SmokedTwigRenderer\ValueObject\DummyTheme;
use Twig\Environment;
use Twig\TwigFunction;

final class SafeEnvironmentDecorator implements EnvironmentDecoratorInterface
{
    public function decorate(Environment $environment): void
    {
        $environment->addFunction(new TwigFunction('dynamicTemplate', function () {
            return DummyTheme::LAYOUT_NAME;
        }));
    }
}
