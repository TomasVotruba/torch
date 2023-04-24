<?php

declare(strict_types=1);

use SmokedTwigRenderer\Contract\EnvironmentDecoratorInterface;
use SmokedTwigRenderer\Tests\Twig\Source\SafeEnvironmentDecorator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(SafeEnvironmentDecorator::class);
    $services->alias(EnvironmentDecoratorInterface::class, SafeEnvironmentDecorator::class);
};
