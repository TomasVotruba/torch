<?php

declare (strict_types=1);
namespace Torch202308\TomasVotruba\Torch\Contract;

use Torch202308\Twig\Environment;
interface TwigEnvironmentDecoratorInterface
{
    public function decorate(Environment $twigEnvironment) : void;
}
