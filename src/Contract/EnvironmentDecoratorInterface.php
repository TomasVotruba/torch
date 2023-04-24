<?php

declare(strict_types=1);

namespace SmokedTwigRenderer\Contract;

use Twig\Environment;

interface EnvironmentDecoratorInterface
{
    public function decorate(Environment $environment): void;
}
