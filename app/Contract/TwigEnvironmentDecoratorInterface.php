<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Contract;

use Twig\Environment;

interface TwigEnvironmentDecoratorInterface
{
    public function decorate(Environment $twigEnvironment): void;
}
