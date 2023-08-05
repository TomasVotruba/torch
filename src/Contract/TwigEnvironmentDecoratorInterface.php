<?php

declare (strict_types=1);
namespace TomasVotruba\Torch\Contract;

use Torch202308\Twig\Environment;
interface TwigEnvironmentDecoratorInterface
{
    public function decorate(Environment $twigEnvironment) : void;
}
