<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Contract;

use Twig\Environment;

interface EnvironmentDecoratorInterface
{
    public function decorate(Environment $environment): void;
}
